<?php

namespace App\Controllers;

class Bahan extends BaseController
{
    public function __construct() {
        $this->Bahan = new \App\Models\Bahan();
		$this->porsi = new \App\Models\PorsiModel();
		$this->resep = new \App\Models\ResepModel();
        $this->Kategori = new \App\Models\KategoriBahanModel();
		// $this->resep_detail = new \App\Models\Resepdetail();

        // Mengambil idUser
        $this->User = new \App\Models\userModel();
        $this->idUser = $this->User->getData(['uniqueCode' => session()->get('id')], 'id');
    }

    public function index(){
        $requestedKategori = htmlspecialchars($this->request->getVar('kategori'));

        $requestedKategori = $this->Kategori->getData(['uniqueCode' => $requestedKategori], ['id', 'uniqueCode', 'nama']);

        // handle data kategori bahan
        $kategoriList = $this->Kategori->getData(0, ['id', 'uniqueCode', 'nama']);
        if (!$kategoriList) {
            $data= [
                'produk' => [],
                'kategori' => [],
                'selectedKategori' => '',
                'selectedProduk' => []
            ];

            return view('bahan', $data);
        }
        $kategoriList = (isset($kategoriList[0]))?$kategoriList:[$kategoriList];
        
        // membuat kategori terpilih
        $selectedKategori = (in_array($requestedKategori, $kategoriList))?$requestedKategori:$kategoriList[0];

        // handle bahan data
        $bahan = $this->Bahan->getData(['idUser' => $this->idUser, 'idKategori' => $selectedKategori['id']]);
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

    public function insertDataBahan(){
        return view('bahan/insertBahan');
    }

    public function proses_insertDataBahan(){
        $idKategori = $this->Kategori->getData(['uniqueCode' => $this->request->getPost('category')], ['id']);
        
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
        $cek = $this->Bahan->insertData($data);

        if(!$cek){
            $this->session->set_flashdata('message', 'Error');
        }
        
        return redirect()->to(base_url('bahan'));
    }

    public function editDataBahan($id){
        $bahan = $this->Bahan->getData(['id' => $id]);
        if($bahan){
            // sementara
            $bahan['uniqueCode'] = $bahan['id'];
            // sementara
        }

        $data = [
            'bahan' => $bahan,
        ];

        return view('bahan/editbahan',$data);
    }

    public function proses_editDataBahan($uniqueCode){
        $idKategori = $this->Kategori->getData(['uniqueCode' => $this->request->getPost('category')], ['id']);

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
        if ($this->Bahan->getData(['uniqueCode' => $uniqueCode])) {
            $isUpdated = $this->Bahan->updateData($data, ['uniqueCode' => $uniqueCode]);
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
        $cek = $this->Bahan->deleteData(['uniqueCode' => $id]);

        if(!$cek){
            return $this->response->setStatusCode(400);
        }else{
            return $this->response->setStatusCode(200);
        }
    }

    public function proses_tambahKategoriBahan()
    {
        $kategori = $this->request->getPost('category');
        
        $idKategori = $this->Kategori->insertData([
            'nama' => $kategori,
            'idUser'   => $this->idUser,
        ]);

        if ($idKategori) {
            return redirect()->to('/bahan');
        }
    }

    public function getKategori(){
        return($this->Bahan->getData(0,'kategori'));
    }

    public function getSubBahan(){
        $data = ($this->Bahan->getData(0, 'subBahan'));
        return($data);
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