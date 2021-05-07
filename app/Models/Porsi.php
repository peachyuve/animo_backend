<?php namespace App\Models;

use CodeIgniter\Model;

class Porsi extends BaseModel
{
    protected $table      = 'Porsi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['uniqueCode','idProduk','jumPorsi','totBiaya','biayaSatuan','createDate','updateDate','deleteDate'];
}

