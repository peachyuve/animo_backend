<?php namespace App\Models;

use CodeIgniter\Model;

class Resep extends BaseModel
{
    protected $table      = 'Resep';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['uniqueCode','idPorsi','ukuranResep','hargaTotal','createDate','updateDate','deleteDate'];
}

