<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\userModel;

class Produk extends Controller
{

    public function __construct()
    {
        session()->set(['id' => 'q3S67']);

        // Mendeklarasikan class ProductModel menggunakan $this->product
        $this->produk = new ProdukModel();
        // $this->kategori = new KategoriModel();
        /* Catatan:
        Apa yang ada di dalam function construct ini nantinya bisa digunakan
        pada function di dalam class Product 
        */
    }

    public function index()
    {
        $kategoriList = $this->produk->kategori();

        $kategori = htmlspecialchars($this->request->getVar('kategori'));
        $produk = htmlspecialchars($this->request->getVar('produk'));

        $selectedKategori = (in_array($kategori, $kategoriList))?$kategori:$kategoriList[0];

        $produkList = $this->produk->getProduk($data = false, $column = false, $orderBy = false, $typeOrder = 'desc', $selectedKategori);
        // handle harga dan id
        foreach ($produkList as $keyProdukList => $valProdukList) {
            $produkList[$keyProdukList]['id'] = $valProdukList['uniqueCode'];
        }

        $data= [
            'produk' => $produkList,
            'kategori' => $kategoriList,
            'selectedKategori' => $selectedKategori,
        ];

        // handle product data
        foreach ($data['produk'] as $keyProduk => $valProduk) {
            if ($valProduk['id'] == $produk) {
                $data['produk'][$keyProduk]['isSelected'] = 1;
                $data['selectedProduk'] = $valProduk;
            }else{
                $data['produk'][$keyProduk]['isSelected'] = 0;
            }
        }
        if (!isset($data['selectedProduk'])) {
            $data['produk'][0]['isSelected'] = 1;
            $data['selectedProduk'] = $data['produk'][0];
        }

        // print('<pre>'.print_r($data,true).'</pre>');

        //dd($data);
        return view('produk', $data);
    }


    public function create()
    {
        $data['produk'] = $this->produk->getProduk();
        return view('produk/create', $data);
    }


    public function save()
    {

        // Mengambil value dari form dengan method POST
        $name = $this->request->getPost('product');
        $size = $this->request->getPost('size');
        $satuan = $this->request->getPost('unit');
        $price = $this->request->getPost('price');
        $category = $this->request->getPost('category');

        // Mengambil idUser
        $idUser = new userModel();
        $idUser = $idUser->getData(['uniqueCode' => session()->get('id')], 'id');

        // Membuat array collection yang disiapkan untuk insert ke table
        $data = [
            'idUser' => $idUser,
            'nama' => $name,
            'ukuran' => $size,
            'satuan' => $satuan,
            'harga' => $price,
            'nama_kategori' => $category,
        ];

        /* 
        Membuat variabel simpan yang isinya merupakan memanggil function 
        insert_product dan membawa parameter data 
        */
        $simpan = $this->produk->insert_produk($data);

        // Jika simpan berhasil, maka ...
        if ($simpan) {
            // Deklarasikan session flashdata dengan tipe success
            session()->setFlashdata('success', 'Created product successfully');
            // Redirect halaman ke product
            return redirect()->to(base_url('produk'));
        }
    }


    public function edit($uniqueCode)
    {
        // Memanggil function getProduct($id) dengan parameter $id di dalam ProductModel dan menampungnya di variabel array product
        $produk = $this->produk->getProduk(['uniqueCode' => $uniqueCode]);
        $data['produk'] = $produk ? $produk[0] : false;
        // Mengirim data ke dalam view
        return redirect()->to(base_url('produk'));
    }

    public function update($uniqueCode)
    {
        // Mengambil value dari form dengan method POST
        $name = $this->request->getPost('product');
        $size = $this->request->getPost('size');
        $satuan = $this->request->getPost('unit');
        $price = $this->request->getPost('price');

        // Membuat array collection yang disiapkan untuk insert ke table
        $data = [
            'nama' => $name,
            'ukuran' => $size,
            'harga' => $price,
            'harga' => $price
        ];

        /* 
        Membuat variabel ubah yang isinya merupakan memanggil function 
        update_product dan membawa parameter data beserta id
        */
        $ubah = $this->produk->update_produk($data, $uniqueCode);

        // Jika berhasil melakukan ubah
        if ($ubah) {
            // Deklarasikan session flashdata dengan tipe info
            session()->setFlashdata('info', 'Updated product successfully');
            // Redirect ke halaman product
            return redirect()->to(base_url('produk'));
        }
    }

    public function delete($uniqueCode)
    {
        // Memanggil function delete_product() dengan parameter $id di dalam ProductModel dan menampungnya di variabel hapus
        $hapus = $this->produk->delete_produk(['uniqueCode' => $uniqueCode]);

        // Jika berhasil melakukan hapus
        if ($hapus) {
            // Deklarasikan session flashdata dengan tipe warning
            session()->setFlashdata('warning', 'Deleted product successfully');
            // Redirect ke halaman product
            return redirect()->to(base_url('produk'));
        }
    }
}
