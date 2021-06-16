<?php namespace App\Controllers;

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
        $email = $this->request->getVar('email');
        $userpassword = $this->request->getVar('userpassword');
        
        $data = $model->where('email', $email)->first(); // login dengan email
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($userpassword, base64_decode($pass));
            if(true){
            // if ($verify_pass) {
                // create inisial
                $words = explode(" ", $data['nama']);
                $acronym = "";
                foreach ($words as $w) {
                  $acronym .= $w[0];
                }

                $ses_data = [
                    'id'       => $data['uniqueCode'],
                    'nama'     => $data['nama'],
                    'inisial'  => $acronym,
                    'email'    => $data['email'],
                    'folderTkn'=> $data['publicFolderToken'],
                    'logged_in'=> TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/');
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
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
