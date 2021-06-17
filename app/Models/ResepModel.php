<?php

namespace App\Models;

class ResepModel extends BaseModel
{
    protected $table      = 'resep'; // nama tabel yang terhubung
    protected $primaryKey = 'id'; // primary key tabel
    protected $returnType = 'array'; 
    protected $allowedFields= ['id','uniqueCode','idPorsi','idBahan','jumBahan','hargaBahan','hargaPerSatuan','ukuranResep','hargaTotal']; // kolom yang bisa dilakukan input, update, delete

    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleteDate';

    public function getResep($idUser, $idProduk = null, $kategoriBahan = null, $column=false, $orderBy=false, $typeOrder = 'desc', $isIncludeDelete = false)
    {
        // Order By
        (!$orderBy)?null:$this->orderBy($orderBy, $typeOrder);

        // $this->select('resep.*');

        // join by produk
        $this->join('porsi', 'resep.idPorsi = porsi.id');
        $this->join('produk', 'porsi.idProduk = produk.id');
        if($idProduk)$this->where('produk.id', $idProduk);

        // join by bahan
        $this->join('bahan', 'resep.idBahan = bahan.id');
        if($kategoriBahan)$this->where('bahan.kategori', $kategoriBahan);

        $this->join('user', 'produk.idUser = user.id');
        $this->where('user.id', $idUser);

        // group by porsi
        $this->groupBy('porsi.id');

        // Get result
        if($column == false) {
            $result = $this->findAll();
        }elseif (gettype($column) != 'array') {
            $result = $this->findColumn($column);
        }else{
            $resultArr = [];
            $result = $this->findAll();
            for ($i=0; $i < count($column); $i++) { 
                for ($j=0; $j < count($result); $j++) { 
                    $resultArr[$j][$column[$i]] = $result[$j][$column[$i]];
                }
            }
            $result = $resultArr;
        }

        // Output result
        if (!$result) {
            return false;
        }elseif (count($result) == 1) {
            return $result[0];
        }else {
            return $result;
        }
    }
}
