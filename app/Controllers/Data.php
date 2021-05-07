<?php

namespace App\Controllers;
use CodeIgniter\Model;

class Data extends BaseController
{
    public function index(){
        $this->session->set('islogin','Login'); // hanya untuk test login
        $this->session->set('uniqueCode','asd');// hanya untuk test login
        $this->session->set('user','RIvan'); // hanya untuk test login
        // $this->session->destroy(); // hanya untuk test logout
        if (isset($this->session->islogin)) {
            return $this->getDataBahan();
        }else {
            echo "Login Dulu";
        }
    }
    
    public function getDataBahan(){
        
        $Nama['bahan'] = $this->Bahan->getData(['deleteDate' => null]);
        print_r($Nama['subbahan']);
        return view('getbahan', $Nama);
        
    }

    public function insertDataBahan(){

        return view('insertBahan');
    }
    public function proses_insertDataBahan(){
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

        $cek = $this->Bahan->insertData($data);
        if(!$cek){
            $this->session->set_flashdata('message', 'Error');
        }else{
            $Nama['bahan'] = $this->Bahan->getData(['deleteDate' => null]);
            return view('getbahan', $Nama);

        }

    }

    public function editDataBahan($id){
        $data['id'] = $id;
        return view('editbahan',$data);
    }

    public function proses_editDataBahan(){
        $this->helpers = ['form', 'url'];
        $data = [
            'idUser' => $this->request->getPost('idUser'),
            'nama' => $this->request->getPost('nama'),
            'kategori' => $this->request->getPost('kategori'),
            'satuan' => $this->request->getPost('satuan'),
            'subBahan' => $this->request->getPost('subBahan'),
            'merk' => $this->request->getPost('merk'),
            'suplier' => $this->request->getPost('suplier'),
            'linkSuplier' => $this->request->getPost('linkSuplier')
        ];
        $id = $this->request->getPost('id');
        $cek = $this->Bahan->updateData($data,['id' => $id]);
        $Nama['bahan'] = $this->Bahan->getData(['deleteDate' => null]);
        return view('getbahan', $Nama);

    }

    public function proses_deleteDataBahan($id){
        $cek = $this->Bahan->deleteData(['id' => $id]);
        if(!$cek){
            $this->session->set_flashdata('message', 'Error');
        }else{
            $Nama['bahan'] = $this->Bahan->getData(['deleteDate' => null]);
            return view('getbahan', $Nama);

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