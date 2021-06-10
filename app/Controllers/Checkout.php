<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\stokbahanmodel;


class checkout extends BaseController
{
    public function __construct()
    {
        // // Mendeklarasikan class ProductModel menggunakan $this->product
        // $this->product = new stokbahanmodel();

        // Mengambil idUser
        $this->idUser = new \App\Models\userModel();
        $this->idUser = $this->idUser->getData(['uniqueCode' => session()->get('id')], 'id');        
    }

    public function index()
    {
        echo view('checkout');
    }
}
