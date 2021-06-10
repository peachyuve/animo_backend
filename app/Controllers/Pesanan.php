<?php namespace App\Controllers;

class Pesanan extends BaseController
{
	public function index()
	{
		$idUser = $this->user->getData(['uniqueCode' => session()->get('id')], 'id');
		$pesananArr = $this->pesanan->getPesanan($idUser, ['tglPemesanan', 'nama', 
			'jumlah', 'statusPembayaran', 'statusPemesanan']);
	}

	public function input()
	{
		
	}

	public function proses_input()
	{
		$rules = [
			'nama'               => 'required',
			'produk'             => 'required',
			'jumlah'             => 'required',
			'tanggal'            => 'required',
			'statusPembayaran'   => 'required',
			'statusPesanan'      => 'required',
		];

		if ($this->validate($rules)) {
			$data = [
				'nama'                => $this->request->getVar('nama'),
				'produk'              => $this->request->getVar('produk'),
				'jumlah'              => $this->request->getVar('jumlah'),
				'tglPemesanan'        => $this->request->getVar('tanggal'),
				'statusPembayaran'    => $this->request->getVar('statusPembayaran'),
				'statusPemesanan'     => $this->request->getVar('statusPesanan'),
			];	

			// set idProduk
			$idProduk = $this->produk->getData(['nama' => $data['produk']], ['id']);
			$data['idProduk'] = $idProduk;
			unset($data['produk']);

			if($id = $this->pesanan->insertData($data)){
				return redirect()->to('/pesanan')->withInput();
			}else{
				return redirect()->to('/pesanan/input')->withInput();
			}
		}
	}

}
