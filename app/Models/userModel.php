<?php namespace App\Models;

use CodeIgniter\Model;

class userModel extends BaseModel
{
    protected $table      = 'user'; // nama tabel yang terhubung
    protected $primaryKey = 'id'; // primary key tabel
    protected $returnType = 'array'; 
    protected $allowedFields= ['id','uniqueCode','nama','email','token','password','kota','deleteDate']; // kolom yang bisa dilakukan input, update, delete
    
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleteDate';
}