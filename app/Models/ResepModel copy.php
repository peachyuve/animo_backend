<?php

namespace App\Models;

class ResepModelCopy extends BaseModel
{
    protected $table      = 'resep'; // nama tabel yang terhubung
    protected $primaryKey = 'id'; // primary key tabel
    protected $returnType = 'array'; 
    protected $allowedFields= ['id','uniqueCode','idPorsi','idBahan','jumBahan','hargaBahan','hargaPerSatuan','ukuranResep','hargaTotal']; // kolom yang bisa dilakukan input, update, delete

    public function GetProduct($column = false, $idUser = false, $orderBy = false, $typeOrder = 'desc')
    {
        $builder = $this->db->table('User');
        $builder->select('*');
        $builder->join('produk','Produk.idUser = user.id');
        $builder->where("user.id",$idUser);
        
        (!$orderBy) ? null : $this->orderBy($orderBy, $typeOrder);
        
        $resultArr = [];
        $result = $builder->get()->getResultArray();
        for ($i = 0; $i < count($column); $i++) {
            for ($j = 0; $j < count($result); $j++) {
                $resultArr[$j][$column[$i]] = $result[$j][$column[$i]];
            }
        }
        $result = $resultArr;
        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    public function viewResep($column = false, $idUser = false, $idproduk = false, $kategori = false, $orderBy = false, $typeOrder = 'desc')
    {
        $builder = $this->db->table('User');
        $builder->select('Bahan.subBahan, resep.jumBahan, resep.hargaBahan, resep.hargaPerSatuan, resep.ukuranResep');
        $builder->join('produk','produk.idUser = user.id');
        $builder->join('porsi','porsi.idProduk = produk.id');
        $builder->join('resep','resep.idPorsi = porsi.id');
        $builder->join('menggunakan','menggunakan.idResep = resep.id');
        $builder->join('bahan','menggunakan.idBahan = bahan.id');
        $builder->join('Stok','Stok.idBahan = Bahan.id');
        $builder->where('Bahan.kategori', "Bahan Baku");
        $builder->where('Produk.id', $idproduk);
        $builder->where('user.id',$idUser);
        

        
        (!$orderBy) ? null : $this->orderBy($orderBy, $typeOrder);
        
        $resultArr = [];
        $result = $builder->get()->getResultArray();
        for ($i = 0; $i < count($column); $i++) {
            for ($j = 0; $j < count($result); $j++) {
                $resultArr[$j][$column[$i]] = $result[$j][$column[$i]];
            }
        }
        $result = $resultArr;
        if (!$result) {
            return false;
        } elseif (count($result) == 1) {
            return $result[0];
        } else {
            return $result;
        }
    }

    public function GetBahanBaku($column = false, $idUser = false, $orderBy = false, $typeOrder = 'desc')
    {
        $builder = $this->db->table('Bahan');
        $builder->where("idUser",$idUser);
        $builder->where("Kategori","Bahan Baku");
        
        (!$orderBy) ? null : $this->orderBy($orderBy, $typeOrder);
        
        $resultArr = [];
        $result = $builder->get()->getResultArray();
        for ($i = 0; $i < count($column); $i++) {
            for ($j = 0; $j < count($result); $j++) {
                $resultArr[$j][$column[$i]] = $result[$j][$column[$i]];
            }
        }
        $result = $resultArr;
        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    public function GetPorsi($column = false, $idUser = false,$idPorsi=false, $orderBy = false, $typeOrder = 'desc')
    {
        $builder = $this->db->table('User');
        $builder->select('*');
        $builder->join('produk','Produk.idUser = user.id');
        $builder->join('porsi','porsi.idProduk = Produk.id');
        $builder->join('resep','resep.idPorsi = porsi.id');
        $builder->where("user.id",$idUser);
        $builder->where("resep.idPorsi",$idPorsi);
        
        (!$orderBy) ? null : $this->orderBy($orderBy, $typeOrder);
        
        $resultArr = [];
        $result = $builder->get()->getResultArray();
        for ($i = 0; $i < count($column); $i++) {
            for ($j = 0; $j < count($result); $j++) {
                $resultArr[$j][$column[$i]] = $result[$j][$column[$i]];
            }
        }
        $result = $resultArr;
        if (!$result) {
            return false;
        }elseif (count($result) == 1) {
            return $result[0];
        }else {
            return $result;
        }
    }
}
