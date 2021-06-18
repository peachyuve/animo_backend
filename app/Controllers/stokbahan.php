<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\stokbahanmodel;

class stokbahan extends BaseController
{
    public function __construct()
    {
        // Mengambil idUser
        $this->idUser = new \App\Models\userModel();
        $this->idUser = $this->idUser->getData(['uniqueCode' => session()->get('id')], 'id');        
    }

    public function index()
    {
        // mengambil bahan terpilih
        $idBahan = $this->request->getVar('bahan');
        $selectedBahan = $this->bahan->getData(['uniqueCode' => $idBahan, 'idUser' => $this->idUser], [
            'nama'
        ]);

        if (!$selectedBahan) {
            $idBahan = 'All';
            $selectedBahan = 'Semua Bahan';
        }

        // mengambil data bahan
        $bahanArr = $this->bahan->getData(['idUser' => $this->idUser], [
            'uniqueCode', 'nama'
        ]);
        if (!$bahanArr) {
            $data = [
                'stok' => [],
                'bahan' => [],
                'selectedBahan' => 'Semua Bahan',
            ];
    
            return view('stok_bahan', $data);
        }
        $bahanArr = (isset($bahanArr[0]))?$bahanArr:[$bahanArr];
        array_walk($bahanArr, array($this, 'idToUniqueCode'));        

        // mengambil data stok
        $model = new stokbahanmodel();
        $stokArr = ($idBahan && $idBahan != 'All')?
            $model->getStok($idBahan, $this->idUser)
            :
            $model->getStok(0, $this->idUser)
        ;

        $data = [
            'stok' => $stokArr,
            'bahan' => $bahanArr,
            'selectedBahan' => $selectedBahan,
        ];

        return view('stok_bahan', $data);
    }

    public function update($id)
    {
        $model = new stokbahanmodel();

        // cek stok
        $stok = $model->getData(['uniqueCode' => $id], [
            'idBahan', 'tglUpdate', 'stokAwal', 'stokMasuk', 'stokKeluar', 'stokAkhir'
        ]);
        if (!$stok) {
            session()->setFlashdata('message', 'Error');
            return redirect()->to('/stokbahan');
        }

        // Mengambil value dari form dengan method POST
        $jenisStok = $this->request->getPost('jenisStok');
        $updateDate = $this->request->getPost('date');
        $jumlah = $this->request->getPost('jumlah');

        // Membuat array collection yang disiapkan untuk insert ke table
        $data = $stok;
        $data['tglUpdate'] = $updateDate;

        // Memilih jenis stok yang diupdate
        switch ($jenisStok) {
            case 'awal':
                $data['stokAwal'] = $jumlah;
                $data['stokAkhir'] = $jumlah + $stok['stokMasuk'] - $stok['stokKeluar'];
                break;
            case 'masuk':
                $data['stokMasuk'] = $jumlah;
                $data['stokAkhir'] = $stok['stokAwal'] + $jumlah - $stok['stokKeluar'];
                break;
            case 'keluar':
                $data['stokKeluar'] = $jumlah;
                $data['stokAkhir'] = $stok['stokAwal'] + $stok['stokMasuk'] - $jumlah;
                break;
            default:
                # code...
                break;
        }

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
