<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{

		$this->session->set('islogin','Login'); // hanya untuk test login
		$this->session->set('uniqueCode','asd');// hanya untuk test login
		$this->session->set('id','3');// hanya untuk test login
		$this->session->set('user','RIvan'); // hanya untuk test login
		// $this->session->destroy(); // hanya untuk test logout
		if (isset($this->session->islogin)) {
			return $this->Dashboard();
		}else {
			echo "Login Dulu";
		}
		
	}
	public function Dashboard()
	{
		$uniq = $this->session->uniqueCode;
		$data['pesanan'] = $this->Dashboard->GetPesanan(['uniqueCode','nama', 'harga','ukuran', 'jumlah']);
		$data['stock'] = $this->Dashboard->StockHabis(['nama','satuan', 'stokAkhir'],$uniq);
		
		return view('dashboard',$data);
	}
}
