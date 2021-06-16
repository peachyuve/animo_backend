<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\userModel;
use App\Models\Bahan;

class Produk extends Controller
{

    public function __construct()
    {
        $this->produk = new ProdukModel();
        $this->kategori = new KategoriModel();
        $this->bahan = new Bahan();
    }

    public function index()
    {
        $kategori = htmlspecialchars($this->request->getVar('kategori'));
        $produk = htmlspecialchars($this->request->getVar('produk'));

        // handle kategori data
        $kategoriList = $this->kategori->getData(0, ['id', 'nama']);
        if (!$kategoriList) {
            $data= [
                'produk' => [],
                'kategori' => [],
                'selectedKategori' => '',
                'selectedProduk' => []
            ];

            return view('produk', $data);
        }
        $kategoriList = (isset($kategoriList[0]))?$kategoriList:[$kategoriList];

        // membuat kategori terpilih
        $selectedKategori = (in_array($kategori, $kategoriList))?$kategori:$kategoriList[0];

        // handle produk data
        $produkList = $this->produk->getProduk();
        if ($produkList) {

            $produkList = $this->produk->getProduk(
                $data = 0,
                $column = 0,
                $orderBy = 0,
                $typeOrder = 'desc', 
                $selectedKategori['id']
            );
    
            // handle harga dan id
            foreach ($produkList as $keyProdukList => $valProdukList) {
                $produkList[$keyProdukList]['id'] = $valProdukList['uniqueCode'];
            }

            // cari produk yang di pilih
            foreach ($produkList as $keyProduk => $valProduk) {
                if ($valProduk['id'] == $produk) {
                    $produkList[$keyProduk]['isSelected'] = 1;
                    $selectedProduk = $valProduk;
                }else{
                    $produkList[$keyProduk]['isSelected'] = 0;
                }
            }
            if (!isset($selectedProduk)) {
                $produkList[0]['isSelected'] = 1;
                $selectedProduk = $produkList[0];
            }
            
            // menambahkan data nama img produk
            $selectedProduk['imgName'] = explode('/', $selectedProduk['img']);
            $selectedProduk['imgName'] = end($selectedProduk['imgName']);

            // mengubah spasi menjadi %20
            $selectedProduk['img'] = str_replace(' ', '%20', $selectedProduk['img']);

            // ambil data bahan
            $selectedBahan = $this->bahan->getBahanByProduk($selectedProduk['id']);
        }else {
            $produkList = [];
            $selectedProduk = [];
        }
    
        $data= [
            'produk' => $produkList,
            'kategori' => $kategoriList,
            'selectedKategori' => $selectedKategori,
            'selectedProduk' => $selectedProduk,
            'selectedBahan' => ($selectedBahan)?$selectedBahan:[],
        ];

        return view('produk', $data);
    }

    public function tambahKategori()
    {
        $kategori = $this->request->getPost('category');
        
        // Mengambil idUser
        $idUser = new userModel();
        $idUser = $idUser->getData(['uniqueCode' => session()->get('id')], 'id');
        
        $idKategori = $this->kategori->insertData([
            'kategori' => $kategori,
            'idUser'   => $idUser,
        ]);

        if ($idKategori) {
            return redirect()->to('/produk');
        }
    }


    public function save()
    {

        // Mengambil value dari form dengan method POST
        $name = $this->request->getPost('product');
        $size = $this->request->getPost('size');
        $satuan = $this->request->getPost('unit');
        $price = $this->request->getPost('price');
        $category = $this->request->getPost('category');
        $image = $this->request->getFile('image');

        // Mengambil idUser
        $idUser = new userModel();
        $idUser = $idUser->getData(['uniqueCode' => session()->get('id')], 'id');

        // Membuat path image
        $imgPath = 'user/'.session()->get('folderTkn').'/img/produk/';

        // get nama image
        $imageName = $image->getName();

        // Membuat array collection yang disiapkan untuk insert ke table
        $data = [
            'idUser' => $idUser,
            'nama' => $name,
            'ukuran' => $size,
            'satuan' => $satuan,
            'harga' => $price,
            'idKategori' => $category,
            'img' => $imgPath.$imageName,
        ];

        /* 
        Membuat variabel simpan yang isinya merupakan memanggil function 
        insert_product dan membawa parameter data 
        */
        $simpan = $this->produk->insert_produk($data);

        // Jika simpan berhasil, maka ...
        if ($simpan) {
            // Pindah file ke direktory user
            $image->move($imgPath, $imageName);
            // Deklarasikan session flashdata dengan tipe success
            session()->setFlashdata('success', 'Created product successfully');
            // Redirect halaman ke product
            return redirect()->to(base_url('produk'));
        }
    }

    public function update($uniqueCode)
    {
        // Mengambil value dari form dengan method POST
        $name = $this->request->getPost('product');
        $size = $this->request->getPost('size');
        $satuan = $this->request->getPost('unit');
        $price = $this->request->getPost('price');
        $image = $this->request->getFile('image');

        // ambil path image lama
        $tempImgPath = $this->produk->getProduk(['uniqueCode' => $uniqueCode], ['img'])[0];

        // Membuat path image
        $imgPath = 'user/'.session()->get('folderTkn').'/img/produk/';
        $imageName = $image->getName();

        // Membuat array collection yang disiapkan untuk insert ke table
        $data = [
            'nama' => $name,
            'ukuran' => $size,
            'harga' => $price,
            'satuan' => $satuan,
            'img' => ($image->getName())?$imgPath.$imageName:$tempImgPath,
        ];

        /* 
        Membuat variabel ubah yang isinya merupakan memanggil function 
        update_product dan membawa parameter data beserta id
        */
        $ubah = $this->produk->update_produk($data, $uniqueCode);

        // Jika berhasil melakukan ubah
        if ($ubah) {
            // cek jika file sudah ada ubah file lama dengan file baru
            if(!file_exists($imgPath.$imageName)){
                if (file_exists($tempImgPath)) {
                    unlink($tempImgPath);
                }
                $image->move($imgPath, $imageName);
            }

            // Deklarasikan session flashdata dengan tipe info
            session()->setFlashdata('info', 'Updated product successfully');
            // Redirect ke halaman product
            return redirect()->to(base_url('produk'));
        }
    }

    public function delete($uniqueCode)
    {
        /* 
        Memanggil function delete_product() dengan parameter $id 
        di dalam ProductModel dan menampungnya di variabel hapus
        */
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
