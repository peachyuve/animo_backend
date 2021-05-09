<?php namespace App\Models;

use CodeIgniter\Model;

class contohClass extends BaseModel
{
    protected $table      = 'Porsi'; // nama tabel yang terhubung
    protected $primaryKey = 'id'; // primary key tabel
    protected $returnType = 'array'; 
    protected $allowedFields= ['id','uniqueCode','idProduk','jumPorsi']; // kolom yang bisa dilakukan input, update, delete
}