<?php

namespace App\Controllers;

class Bahan extends BaseController
{
    public function __construct() {
		$this->porsi = new \App\Models\PorsiModel();
		$this->resep = new \App\Models\ResepModel();

        // Mengambil idUser
        $this->User = new \App\Models\userModel();
        $this->idUser = $this->User->getData(['uniqueCode' => session()->get('id')], 'id');
    }

    public function index(){
        $requestedKategori = htmlspecialchars($this->request->getVar('kategori'));

        $requestedKategori = $this->kategoriBahan->getData(['uniqueCode' => $requestedKategori], ['id', 'uniqueCode', 'nama']);

        // handle data kategori bahan
        $kategoriList = $this->kategoriBahan->getData(['idUser'=>$this->idUser], ['id', 'uniqueCode', 'nama']);
        if (!$kategoriList) {
            $data= [
                'bahan' => [],
                'kategori' => [],
                'selectedKategori' => [
                    'uniqueCode' => null, 
                    'nama' => 'Pilih Kategori'
                ],
            ];

            return view('bahan', $data);
        }
        $kategoriList = (isset($kategoriList[0]))?$kategoriList:[$kategoriList];
        
        // membuat kategori terpilih
        $selectedKategori = (in_array($requestedKategori, $kategoriList))?$requestedKategori:[
                                                                                                'uniqueCode' => null, 
                                                                                                'nama' => 'Pilih Kategori'
                                                                                            ];

        // handle bahan data
        if ($selectedKategori['uniqueCode']) {
            $bahan = $this->bahan->getData(['idUser' => $this->idUser, 'idKategori' => $selectedKategori['id']]);
        }else{
            $bahan = $this->bahan->getData(['idUser' => $this->idUser]);
        }

        if($bahan){
            if (count($bahan) == count($bahan, COUNT_RECURSIVE)) {
                $bahan = [$bahan];
            }
        }else {
            $bahan = [];
        }

        // ubah id ke unique code
        $selectedKategori['id'] = $selectedKategori['uniqueCode'];
        unset($selectedKategori['uniqueCode']);

        array_walk($kategoriList, function(&$val){
            $val['id'] = $val['uniqueCode'];
            unset($val['uniqueCode']);
        });

        array_walk($bahan, function(&$val){
            $val['id'] = $val['uniqueCode'];
            unset($val['uniqueCode']);
        });

        // handle data dengan unsafe word
        foreach ($bahan as $keyBahan => $valBahan) {
            foreach ($valBahan as $keyValBahan => $valValBahan) {
                $bahan[$keyBahan]['safe'.$keyValBahan] = $this->convertToSafeString($valValBahan);
            }   
        }

        $data = [
            'bahan' => $bahan,
            'kategori' => $kategoriList,
            'selectedKategori' => $selectedKategori,
        ];

        // print('<pre>'.print_r($data,true).'</pre>');

        return view('bahan', $data);
    }

    public function proses_insertDataBahan(){
        $idKategori = $this->kategoriBahan->getData(['uniqueCode' => $this->request->getPost('category')], ['id']);
        
        // insert data bahan
        $data = [
            'idUser' => $this->idUser,
            'idKategori' => $idKategori,
            'nama' => $this->request->getPost('material'),
            'satuan' => $this->request->getPost('unit'),
            'subBahan' => $this->request->getPost('subMaterial'),
            'merk' => $this->request->getPost('brand'),
            'suplier' => $this->request->getPost('supplier'),
            'linkSuplier' => $this->request->getPost('contact')
        ];
        print('<pre>'.print_r($data,true).'</pre>');
        $idInsertedBahan = $this->bahan->insertData($data);

        if(!$idInsertedBahan){
            $this->session->set_flashdata('message', 'Error');
        }else {
            $data = [
                'idBahan'       => $idInsertedBahan,
                'tglUpdate'     => date('Y-m-d H:i:s'),
                'stokAwal'      => 0,
                'stokMasuk'     => 0,
                'stokKeluar'    => 0,
                'stokAkhir'     => 0,
            ];
            $idInsertedStok = $this->stokBahan->insertData($data);
            if (!$idInsertedStok) {
                $this->session->set_flashdata('message', 'Error');
            }else {
                $this->bahan->rollbackInsert($idInsertedBahan);
            }
        }
        
        return redirect()->to(base_url('bahan'));
    }

    public function proses_editDataBahan($uniqueCode){
        $idKategori = $this->kategoriBahan->getData(['uniqueCode' => $this->request->getPost('category')], ['id']);

        // get request data
        $data = [
            'idKategori' => $idKategori,
            'nama' => $this->request->getPost('material'),
            'satuan' => $this->request->getPost('unit'),
            'subBahan' => $this->request->getPost('subMaterial'),
            'merk' => $this->request->getPost('brand'),
            'suplier' => $this->request->getPost('supplier'),
            'linkSuplier' => $this->request->getPost('contact')
        ];

        // cek jika id ada
        if ($this->bahan->getData(['uniqueCode' => $uniqueCode])) {
            $isUpdated = $this->bahan->updateData($data, ['uniqueCode' => $uniqueCode]);
            if (!$isUpdated) {
                session()->setFlashdata('message', 'Error');
                die();
            }
        }else{
            session()->setFlashdata('message', 'Error');
            die();
        }

        return redirect()->to(base_url('bahan'));
    }

    public function proses_deleteDataBahan($id){
        $id = $this->bahan->getData(['uniqueCode' => $id], ['id']);
        if (!$id) {
            $this->response->setStatusCode(400);
        }

        $cek = $this->bahan->deleteData(['id' => $id]);
        if(!$cek){
            $this->response->setStatusCode(400);
        }else{
            $this->response->setStatusCode(200);
        }
        print('<pre>'.print_r($this->response->getStatusCode(),true).'</pre>');
    }

    public function proses_tambahKategoriBahan()
    {
        $kategori = $this->request->getPost('category');
        
        $idKategori = $this->kategoriBahan->insertData([
            'nama'     => $kategori,
            'idUser'   => $this->idUser,
        ]);

        if (!$idKategori) {
            session()->setFlashdata('message', 'Error');
        }else {
            // mendapatkan uniqueCode
            $idKategori = $this->kategoriBahan->getData(['id' => $idKategori], ['uniqueCode']);
        }
        return redirect()->to('/bahan?kategori='.$idKategori);
    }

    public function proses_insertDataResep(){
        $this->helpers = ['form', 'url'];
        $data_porsi = [
            'jumPorsi' => $this->request->getPost('jumPorsi'),
            'idProduk' => $this->request->getPost('idProduk'),
            'totBiaya' => $this->request->getPost('totbiaya'),
            'biayaSatuan' => $this->request->getPost('totBiaya') / $this->request->getPost('jumPorsi')
        ];
        $id = $this->Porsi->insertData($data_porsi);
        if(!$id){
            $this->session->set_flashdata('message', 'Error');
        }else{
            $data_resep = [
                'idPorsi' => $id,
                'ukuranResep' => $this->request->getPost('ukuranResep'),
                'hargaTotal' => $this->request->getPost('hargaTotal'),
            ];
            $id = $this->Resep->insertData($data_resep);
            if(!$id){
                $this->session->set_flashdata('message', 'Error');
            }else{
                $data_resepDetail = [

                ];
            }
        }

    }


}