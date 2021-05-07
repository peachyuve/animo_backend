<?php namespace App\Models;

use CodeIgniter\Model;

class Resepdetail extends BaseModel
{
    protected $table      = 'Resep_detail';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['uniqueCode','idResep','idBahan','jumBahan','hargaBahan','subBahan','merk', 'suplier','linkSuplier','createDate','updateDate','deleteDate'];
}

