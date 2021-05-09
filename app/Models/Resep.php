<?php namespace App\Models;

use CodeIgniter\Model;

class Resep extends BaseModel
{
    protected $table      = 'resep'; // nama tabel yang terhubung
    protected $primaryKey = 'id'; // primary key tabel
    protected $returnType = 'array'; 
    protected $allowedFields= ['id','uniqueCode','idPorsi','ukuranResep','hargaTotal']; // kolom yang bisa dilakukan input, update, delete
}