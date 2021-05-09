<?php

namespace App\Models;

use CodeIgniter\Model;

class Dashboard_model extends Model
{
    public function GetPesanan($column = false, $orderBy = false, $typeOrder = 'desc')
    {
        $builder = $this->db->table('Produk');
        $builder->select('*');
        $builder->join('Pesanan','Pesanan.idProduk = Produk.id');
        
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

    public function Stock($column = false, $orderBy = false, $typeOrder = 'desc')
    {
        $builder = $this->db->table('Bahan');
        $builder->select('Bahan.nama, Bahan.satuan, Stok.stokAkhir');
        $builder->join('Stok','Stok.idBahan = Bahan.id');
        $builder->where("(stokAkhir < 30 AND satuan = 'Kg')");
        $builder->orwhere("(stokAkhir < 30 AND satuan = 'liter')");
        $builder->orwhere("(stokAkhir < 30 AND satuan = 'pcs')");
        $builder->orwhere("(stokAkhir < 25 AND satuan = 'butir')");
        

        
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

    public function StockHabis($column = false, $idUser = false, $orderBy = false, $typeOrder = 'desc')
    {
        $builder = $this->db->table('user');
        $builder->select('Bahan.nama, Bahan.satuan, Stok.stokAkhir');
        $builder->join('produk','produk.idUser = user.id');
        $builder->join('porsi','porsi.idProduk = produk.id');
        $builder->join('resep','resep.idPorsi = porsi.id');
        $builder->join('resep_detail','resep_detail.idResep = resep.id');
        $builder->join('bahan','resep_detail.idBahan = bahan.id');
        $builder->join('Stok','Stok.idBahan = Bahan.id');

        // $builder->where("user.uniqueCode",$idUser);
        $builder->where("user.uniqueCode",$idUser,"and  
                        ((stokAkhir < 30 AND satuan = 'Kg') or 
                        (stokAkhir < 30 AND satuan = 'liter') or
                        (stokAkhir < 30 AND satuan = 'pcs') or
                        (stokAkhir < 25 AND satuan = 'butir'))");
        // $builder->where("(stokAkhir < 30 AND satuan = 'liter')");
        // $builder->orwhere("(stokAkhir < 30 AND satuan = 'pcs')");
        // $builder->orwhere("(stokAkhir < 25 AND satuan = 'butir')");
        
        
        
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
}
