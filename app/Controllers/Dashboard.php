<?php 

namespace App\Controllers;

use App\Models\DashboardModel;
use App\Models\userModel;

class Dashboard extends BaseController
{
	public function index()
	{
		$Dashboard = new DashboardModel;

		$uniq = session()->get('id');

		// get user id
		$idUser = new userModel();
		$idUser = $idUser->getData(['uniqueCode' => session()->get('id')], 'id');

		$data['pesanan'] = $Dashboard->GetPesanan(['uniqueCode','nama', 'harga','ukuran', 'jumlah']);
		$data['stock'] = $Dashboard->StockHabis(['uniqueCode', 'nama','satuan', 'stokAkhir'], $idUser);

		// handle data pesanan
		if ($data['pesanan']){
			foreach ($data['pesanan'] as $keyPesanan => $valPesanan) {
				$data['pesanan'][$keyPesanan]['harga'] = number_format($valPesanan['harga'], 0, '', '.');
			}
		}else{
			$data['pesanan'] = [];
		};
		$data['pesananDetail'] = [
			'totalItem' => count($data['pesanan']),
			'page' 		=> '0',
			'totalPage' => ceil(count($data['pesanan'])/4),
		];

		// handle data stok
		if (!$data['stock']) $data['stock'] = [];

		// print('<pre>'.print_r($data,true).'</pre>');
		
		// return view('dashboard', $data);
	}
}
