<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\userModel;

class Register extends Controller
{

    public function index()
    {
        //include helper form
        helper(['form']);
        return view('register');
    }

    public function save()
    {
        //include helper form
        helper(['form']);

        //set rules validation form
        $rules = [
            'business'  => 'required|min_length[3]|max_length[255]|is_unique[user.namaBisnis]',
            'city'      => 'required|min_length[1]|max_length[200]'
        ];
        
        if ($this->validate($rules)) {
            $model = new usermodel();

            // start production
            $user = [
                'nama' => 'irfan',
                'email' => 'irfan@gmail.com',
                'password' => base64_encode(password_hash('irfan123', PASSWORD_ARGON2_DEFAULT_THREADS)),
                'token' => rand(0,255),
            ];
            $token = ['token' => $user['token']];
            $model->insertData($user);
            // end production

            $data = [
                'namaBisnis' => $this->request->getVar('business'),
                'kota'   => $this->request->getVar('city')
            ];
            $model->updateData($data, $token);
            
            return redirect()->to(base_url('/login'));
        } else {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $this->validator);

            return redirect()->to('/register')->withInput();
        }
    }
}
