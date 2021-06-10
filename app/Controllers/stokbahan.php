<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\stokbahanmodel;


class stokbahan extends Controller
{
    public function __construct()
    {
        // // Mendeklarasikan class ProductModel menggunakan $this->product
        // $this->product = new stokbahanmodel();

        // Mengambil idUser
        $this->idUser = new \App\Models\userModel();
        $this->idUser = $this->idUser->getData(['uniqueCode' => session()->get('id')], 'id');        
    }

    public function index()
    {
        $model = new stokbahanmodel();
        $namaBahanCari = $this->request->getVar('nama');
        $data['stok'] = ($namaBahanCari && $namaBahanCari != 'Semua')?
            $model->modelcari($namaBahanCari)
            :
            $model->getBahan(0, $this->idUser)
        ;

        echo view('stokbahan/stokbahan', $data);
    }

    public function edit($id)
    {
        $model = new stokbahanmodel();
        // Memanggil function getProduct($id) dengan parameter $id di dalam ProductModel dan menampungnya di variabel array product
        $data['stok'] = $model->getBahan($id);
        // Mengirim data ke dalam view
        return view('stokbahan/edit', $data);
    }

    public function update($id)
    {
        $model = new stokbahanmodel();
        // Mengambil value dari form dengan method POST
        $updateDate = $this->request->getPost('updateDate');
        $stokAwal = $this->request->getPost('stokAwal');
        $stokMasuk = $this->request->getPost('stokMasuk');
        $stokKeluar = $this->request->getPost('stokKeluar');
        $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar;

        // Membuat array collection yang disiapkan untuk insert ke table
        $data = [
            'idBahan' => $model->getBahan($id)[0]['idBahan'],
            'tglUpdate' => $updateDate,
            'stokAwal' => $stokAwal,
            'stokMasuk' => $stokMasuk,
            'stokKeluar' => $stokKeluar,
            'stokAkhir' => $stokAkhir
        ];

        /* 
        Membuat variabel ubah yang isinya merupakan memanggil function 
        update_product dan membawa parameter data beserta id
        */
        $ubah = $model->updateBahan($data, $id);

        // Jika berhasil melakukan ubah
        if ($ubah) {
            // Deklarasikan session flashdata dengan tipe info
            session()->setFlashdata('info', 'Bahan berhasil di update');
            // Redirect ke halaman product
            return redirect()->to('/stokbahan');
        }
    }
}
