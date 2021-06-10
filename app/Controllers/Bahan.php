<?php

namespace App\Controllers;

class Bahan extends BaseController
{
    public function __construct() {
        $this->Bahan = new \App\Models\Bahan();
		$this->porsi = new \App\Models\Porsi();
		$this->resep = new \App\Models\Resep();
		$this->resep_detail = new \App\Models\Resepdetail();

        // Mengambil idUser
        $this->idUser = new \App\Models\userModel();
        $this->idUser = $this->idUser->getData(['uniqueCode' => session()->get('id')], 'id');
    }

    public function index(){
        $bahan = $this->Bahan->getData(['idUser' => $this->idUser]);
        if($bahan){
            if (count($bahan) == count($bahan, COUNT_RECURSIVE)) {
                $bahan = [$bahan];
            }
            // sementara
                foreach ($bahan as $key => $val) {
                    $bahan[$key]['uniqueCode'] = $bahan[$key]['id'];
                }
            // sementara
        }else {
            $bahan = [];
        }

        $data = [
            'bahan' => $bahan,
        ];

        return view('bahan/getbahan', $data);
    }

    public function insertDataBahan(){
        return view('bahan/insertBahan');
    }

    public function proses_insertDataBahan(){
        $this->helpers = ['form', 'url'];
        
        // insert data bahan
        $data = [
            'idUser' => $this->idUser,
            'nama' => $this->request->getPost('nama'),
            'kategori' => $this->request->getPost('kategori'),
            'satuan' => $this->request->getPost('satuan'),
            'subBahan' => $this->request->getPost('subBahan'),
            'merk' => $this->request->getPost('merk'),
            'suplier' => $this->request->getPost('suplier'),
            'linkSuplier' => $this->request->getPost('linkSuplier')
        ];
        $cek = $this->Bahan->insertData($data);

        if(!$cek){
            $this->session->set_flashdata('message', 'Error');
        }else{
            return redirect()->to(base_url('bahan'));
        }
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

    public function proses_editDataBahan(){
        $this->helpers = ['form', 'url'];
        $data = [
            'nama' => $this->request->getPost('nama'),
            'kategori' => $this->request->getPost('kategori'),
            'satuan' => $this->request->getPost('satuan'),
            'subBahan' => $this->request->getPost('subBahan'),
            'merk' => $this->request->getPost('merk'),
            'suplier' => $this->request->getPost('suplier'),
            'linkSuplier' => $this->request->getPost('linkSuplier')
        ];
        print json_encode($data, JSON_PRETTY_PRINT);
        $id = $this->request->getPost('id');
        $cek = $this->Bahan->updateData($data,['id' => $id]);

        return redirect()->to(base_url('bahan'));
    }

    public function proses_deleteDataBahan($id){
        $cek = $this->Bahan->deleteData(['id' => $id]);
        if(!$cek){
            $this->session->set_flashdata('message', 'Error');
        }else{
            return redirect()->to(base_url('bahan'));
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