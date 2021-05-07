<?php namespace App\Models;

use CodeIgniter\Model;

class contohClass extends BaseModel
{
    protected $table      = 'Bahan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['id','uniqueCode','nama','kategori','satuan','subBahan','merk', 'suplier','linkSuplier'];
}

