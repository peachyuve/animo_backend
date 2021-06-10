<?php namespace App\Models;

use CodeIgniter\Model;

class PorsiModel extends BaseModel
{
    protected $table      = 'Porsi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['id', 'uniqueCode','idProduk','jumPorsi','totBiaya','biayaSatuan','createDate','updateDate','deleteDate'];
}

