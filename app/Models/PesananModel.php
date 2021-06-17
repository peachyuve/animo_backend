<?php namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends BaseModel
{
    protected $table      = 'pesanan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id', 'uniqueCode', 'idProduk', 'namaPemesan', 'jumlah', 'tglPemesanan', 'statusPembayaran', 'statusPemesanan', 'createDate', 'updateDate', 'deleteDate'];

    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleteDate';

    public function getPesanan($idUser, $column=false, $orderBy=false, $typeOrder = 'desc', $isIncludeDelete = false)
    {
        // Order By
        (!$orderBy)?null:$this->orderBy($orderBy, $typeOrder);

        // join 
        $this->join('produk', 'pesanan.idProduk = produk.id');
        $this->join('user', 'produk.idUser = user.id');
        $this->where('user.id', $idUser);

        // Get result
        if($column == false) {
            $result = $this->findAll();
        }elseif (gettype($column) != 'array') {
            $result = $this->findColumn($column);
        }elseif(count($column) == 1) {
            $result = $this->findColumn($column[0]);
        }else{
            foreach ($column as $keyCol => $valCol) {
                if (strpos($valCol, '.')) {
                    $explodedValCol = explode('.', $valCol);
                    if ($explodedValCol[0] != $this->table) {
                        $this->select($valCol.' as '.$explodedValCol[0].'_'.$explodedValCol[1]);
                    }else {
                        $this->select($valCol);
                    }
                }else {
                    $this->select($valCol);
                }
            }
            $result = $this->findAll();
        }

        // Output result
        if (!$result) {
            return false;
        }elseif (count($result) == 1) {
            return $result;
        }else {
            return $result;
        }
    }
}

