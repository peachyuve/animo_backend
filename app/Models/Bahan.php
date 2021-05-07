<?php namespace App\Models;

use CodeIgniter\Model;

class Bahan extends BaseModel
{
    protected $table      = 'Bahan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['uniqueCode','idUser','nama','kategori','satuan','subBahan','merk', 'suplier','linkSuplier','createDate','updateDate','deleteDate'];
}

