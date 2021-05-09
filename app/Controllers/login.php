<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\usermodel;

class Login extends Controller
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
        $data = $model->where('nama', $username)->first();
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($userpassword, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'id'       => $data['id'],
                    'nama'     => $data['nama'],
                    'email'    => $data['email'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('http://localhost:8080/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to('http://localhost:8080/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('http://localhost:8080/login');
    }
}
