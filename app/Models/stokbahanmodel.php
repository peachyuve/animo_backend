<?php

namespace App\Models;

use CodeIgniter\Model;

class stokbahanmodel extends BaseModel
{
    protected $table = 'stok';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['id','uniqueCode','idBahan','tglUpdate','stokAwal','stokMasuk','stokKeluar','stokAkhir','createDate','updateDate','deleteDate'];

    public function getBahan($id = false, $idUser = false)
    {
        $data = $this->db->table('stok')->join('bahan', 'bahan.id = stok.idBahan')->groupBy('stok.idBahan')->orderBy('stok.createDate', 'DESC');
        if($idUser)
            $data = $data->where('bahan.idUser', $idUser);
        if($id)
            $data = $data->where('bahan.id', $id);

        return $data->get()->getResultArray();
    }

    public function modelcari($nama = false, $idUser = false)
    {
        $data = $this->db->table('stok')->join('bahan', 'bahan.id = stok.idBahan')->groupBy('stok.idBahan')->orderBy('stok.createDate', 'DESC');
        if($idUser)
            $data = $data->where('bahan.idUser', $idUser);
        if($id)
            $data = $data->where('bahan.nama', $nama);

        return $data->get()->getResultArray();
    }

    public function updateBahan($data)
    {
        return $this->insertData($data);
    }
}
