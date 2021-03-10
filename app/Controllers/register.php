<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\usermodel;

class Register extends Controller
{
    public function index()
    {
        //include helper form
        helper(['form']);
        $data = [];
        echo view('register', $data);
    }

    public function save()
    {
        //include helper form
        helper(['form']);
        //set rules validation form
        $rules = [
            'businessname'    => 'required|min_length[3]|max_length[255] |is_unique[user.namabisnis]',
            'city'          => 'required|min_length[1]|max_length[200]'
        ];

        if ($this->validate($rules)) {
            $model = new usermodel();
            $data = [
                'namabisnis'     => $this->request->getVar('businessname'),
                'kota'   => $this->request->getVar('city')
            ];
            $model->save($data);
            return redirect()->to('http://localhost:8081/login');
        } else {
            $data['validation'] = $this->validator;
            echo view('register', $data);
        }
    }
}
