<?php namespace App\Models;

use CodeIgniter\Model;

class Bahan extends BaseModel
{
    protected $table      = 'Bahan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['id','uniqueCode','idUser','nama','kategori','satuan','subBahan','merk', 'suplier','linkSuplier','createDate','updateDate','deleteDate'];

    public function getBahanByProduk($id)
    {
        $this->select('bahan.*');
        $this->select('resep.ukuranResep');

        // join
        $this->join('resep', 'resep.idBahan = bahan.id');
        $this->join('porsi', 'resep.idPorsi = porsi.id');
        $this->join('produk', 'produk.id = porsi.idProduk');
        // $this->join('produk', 'produk.id = porsi.idProduk');

        // where
        $this->where('produk.uniqueCode', $id);

        if($result = $this->findAll()){
            return $result;
        }else {
            return false;
        }
    }
}

