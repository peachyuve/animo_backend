<?php namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends BaseModel
{
    protected $table      = 'pesanan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['id', 'uniqueCode', 'idProduk', 'nama', 'jumlah', 'tglPemesanan', 'statusPembayaran', 'statusPemesanan', 'createDate', 'updateDate', 'deleteDate'];

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

