<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\userModel;

class Register extends Controller
{

    public function index()
    {
        //include helper form
        helper(['form']);
        
        // validate user
        $user = new \App\Models\userModel();
        $user = $user->getData(['token' => $this->request->getGet('token')]);
        
        if(!$user){
            return redirect()->to('https://automateall.id/detail?id=1');         
        }
        
        if($user['kota'] && $user['namaBisnis']){
            return redirect()->to('/login');
        }   
        
        $data = ['token' => $this->request->getGet('token')];
        
        return view('register', $data);
    }

    public function save($token)
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

            $data = [
                'namaBisnis' => $this->request->getVar('business'),
                'kota'   => $this->request->getVar('city')
            ];
            $model->updateData($data, ['token' => $token]);
            
            return redirect()->to(base_url('login/auth?token='.$token));
        } else {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $this->validator);

            return redirect()->to('/register')->withInput();
        }
    }
}
