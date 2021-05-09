<?php namespace App\Models;

use CodeIgniter\Model;

class Resepdetail extends BaseModel
{
    protected $table      = 'resep_detail'; // nama tabel yang terhubung
    protected $primaryKey = 'id'; // primary key tabel
    protected $returnType = 'array'; 
    protected $allowedFields= ['id','uniqueCode','idResep','idBahan','jumBahan','hargaBahan','hargaPerSatuan']; // kolom yang bisa dilakukan input, update, delete
}