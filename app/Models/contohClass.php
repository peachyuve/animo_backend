<?php namespace App\Models;

use CodeIgniter\Model;

class contohClass extends BaseModel
{
    protected $table      = 'bahan'; // nama tabel yang terhubung
    protected $primaryKey = 'id'; // primary key tabel
    protected $returnType = 'array'; 
    protected $allowedFields= ['id','token','username','password']; // kolom yang bisa dilakukan input, update, delete
}