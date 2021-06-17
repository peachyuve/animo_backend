<?php

namespace App\Models;

class KategoriBahanModel extends BaseModel
{
    protected $table = "kategoribahan";
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $allowedFields= ['id','uniqueCode','idUser','nama','deleteDate']; // kolom yang bisa dilakukan input, update, delete

    protected $deletedField  = 'deleteDate';
}
