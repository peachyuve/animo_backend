<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    public function GetPesanan($column = false, $idUser = false, $orderBy = false, $typeOrder = 'desc')
    {
        $builder = $this->db->table('Produk');
        $builder->select('*');
        $builder->join('Pesanan','Pesanan.idProduk = Produk.id');

        $builder->where('Pesanan.deleteDate', null);
        $builder->where('Produk.idUser', $idUser);
        
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

    public function StockHabis($column = false, $idUser = false, $orderBy = false, $typeOrder = 'desc')
    {
        $builder = $this->db->table('stok');
        $builder->select('bahan.uniqueCode, bahan.nama, bahan.satuan, Stok.stokAkhir');
        $builder->join('bahan','bahan.id = stok.idBahan');

        $builder->where("bahan.idUser", $idUser);
        $builder->where("stok.deleteDate", null);
        
        $builder->orderBy("stok.createDate", "DESC");
        
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
            // hapus data bahan duplicate
            $temp = '';
            foreach ($result as $keyResult => $valResult) {
                if ($valResult['uniqueCode'] != $temp) {
                    $temp = $valResult['uniqueCode'];
                }else {
                    unset($result[$keyResult]);
                }
            }

            // hapus data stok jika tidak kurang
            foreach ($result as $keyResult => $valResult) {
                switch ($valResult) {
                    case ($valResult['stokAkhir'] > 30 AND $valResult['satuan'] == 'gram'):
                        unset($result[$keyResult]);
                        break;
                    case ($valResult['stokAkhir'] > 30 AND $valResult['satuan'] == 'mililiter'):
                        unset($result[$keyResult]);
                        break;
                    case ($valResult['stokAkhir'] > 5 AND $valResult['satuan'] =='butir'):
                        unset($result[$keyResult]);
                        break;
                }
            }

            return $result;
        }
    }
}
