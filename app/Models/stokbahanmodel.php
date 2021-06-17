<?php

namespace App\Models;

use CodeIgniter\Model;

class stokbahanmodel extends BaseModel
{
    protected $table = 'stok';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['id','uniqueCode','idBahan','tglUpdate','stokAwal','stokMasuk','stokKeluar','stokAkhir','createDate','updateDate','deleteDate'];

    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleteDate';

    public function getStok($id = false, $idUser = false)
    {
        $data = $this->db->table('stok')->join('bahan', 'bahan.id = stok.idBahan')->orderBy('stok.createDate', 'DESC');

        $col = ['stok.uniqueCode as id', 'idBahan',
            'tglUpdate', 'nama', 'subBahan', 'satuan', 
            'stokAwal', 'stokMasuk', 'stokKeluar', 'stokAkhir'];
        foreach ($col as $keyCol => $valCol) {
            $data->select($valCol);
        }

        if($idUser)
            $data = $data->where('bahan.idUser', $idUser);
        if($id)
            $data = $data->where('bahan.uniqueCode', $id);

        $result = $data->get()->getResultArray();

        // hapus data bahan duplicate
        $temp = '';
        foreach ($result as $keyResult => $valResult) {
            if ($valResult['idBahan'] != $temp) {
                $temp = $valResult['idBahan'];
            }else {
                unset($result[$keyResult]);
            }
        }

        return $result;
    }

    public function modelcari($nama = false, $idUser = false)
    {
        $data = $this->db->table('stok')->join('bahan', 'bahan.id = stok.idBahan')->groupBy('stok.idBahan')->orderBy('stok.createDate', 'DESC');

        $col = ['stok.uniqueCode as id',
            'tglUpdate', 'nama', 'subBahan', 'satuan', 
            'stokAwal', 'stokMasuk', 'stokKeluar', 'stokAkhir'];
        foreach ($col as $keyCol => $valCol) {
            $data->select($valCol);
        }

        if($idUser)
            $data = $data->where('bahan.idUser', $idUser);
        if($id)
            $data = $data->where('bahan.nama', $nama);

        // hapus data bahan duplicate
        $temp = '';
        foreach ($result as $keyResult => $valResult) {
            if ($valResult['idBahan'] != $temp) {
                $temp = $valResult['idBahan'];
            }else {
                print('<pre>'.print_r($valResult,true).'</pre>');
                unset($result[$keyResult]);
            }
        }        

        return $data->get()->getResultArray();
    }

    public function updateBahan($data)
    {
        return $this->insertData($data);
    }
}
