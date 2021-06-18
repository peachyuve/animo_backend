<?php

namespace App\Models;

class KategoriModel extends BaseModel
{
    protected $table = "kategoriproduk";
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $allowedFields= ['id','uniqueCode','idUser','nama','deleteDate']; // kolom yang bisa dilakukan input, update, delete

    protected $deletedField  = 'deleteDate';
}
