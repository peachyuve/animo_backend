<?php namespace App\Models;

use CodeIgniter\Model;

class contohClass extends BaseModel
{
    protected $table      = 'user';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields= ['id','token','username','password'];
}