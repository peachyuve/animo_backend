<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\usermodel;

class login extends Controller
{
    public function index()
    {
        helper(['form']);
        echo view('login');
    }

    public function auth()
    {
        $session = session();
        $model = new usermodel();
        $username = $this->request->getVar('username');
        $userpassword = $this->request->getVar('userpassword');
        
        $data = $model->where('email', $username)->first(); // login dengan email
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($userpassword, base64_decode($pass));
            if ($verify_pass) {
                $ses_data = [
                    'id'       => $data['uniqueCode'],
                    'nama'     => $data['nama'],
                    'email'    => $data['email'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        print_r('tot');
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
