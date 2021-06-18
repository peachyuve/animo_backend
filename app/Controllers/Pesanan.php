<?php namespace App\Controllers;

class Pesanan extends BaseController
{
	public function index()
	{
		$idUser = $this->user->getData(['uniqueCode' => session()->get('id')], 'id');

		// get pesanan list
		$pesananArr = $this->pesanan->getPesanan($idUser, ['pesanan.uniqueCode', 'tglPemesanan', 'produk.nama', 
			'namaPemesan', 'jumlah', 'statusPembayaran', 'statusPemesanan', 'produk.uniqueCode']);
		if ($pesananArr) {
			array_walk($pesananArr, function(&$val){
				$val['idProduk'] = $val['produk_uniqueCode'];
			});
			array_walk($pesananArr, array($this, "idToUniqueCode"));
		}else {
			$pesananArr = [];
		}

		// get produk list
		$produkArr = $this->produk->getProduks($idUser, 0, ['uniqueCode', 'nama']);
		if ($produkArr) {
			array_walk($produkArr, array($this, "idToUniqueCode"));
		}else {
			$produkArr = [];
		}

		$data = [
			'pesanan' => $pesananArr,
			'produk' => $produkArr,
		];

		return view('pesanan', $data);
	}

	public function proses_input()
	{
		$rules = [
			'buyer'            => 'required',
			'idProduk'         => 'required',
			'qty'              => 'required',
			'date'             => 'required',
			'paymentStatus'    => 'required',
			'orderStatus'      => 'required',
		];

		if ($this->validate($rules)) {
			$data = [
				'namaPemesan'		  => $this->request->getVar('buyer'),
				'idProduk'            => $this->produk->getData(['uniqueCode' => $this->request->getPost('idProduk')], ['id']),
				'jumlah'              => $this->request->getVar('qty'),
				'tglPemesanan'        => $this->request->getVar('date'),
				'statusPembayaran'    => $this->request->getVar('paymentStatus'),
				'statusPemesanan'     => $this->request->getVar('orderStatus'),
			];

			$id = $this->pesanan->insertData($data);
			if(!$id){
				session()->setFlashdata('message', 'Error');
			}
		}else {
			session()->setFlashdata('message', 'Error Validation');
		}
		// print json_encode(session()->getFlashData(), JSON_PRETTY_PRINT);

		return redirect()->to('/pesanan');
	}

	public function proses_edit($id)
	{
		$rules = [
			'buyer'            => 'required',
			'idProduk'         => 'required',
			'qty'              => 'required',
			'date'             => 'required',
			'paymentStatus'    => 'required',
			'orderStatus'      => 'required',
		];
		if ($this->validate($rules)) {

			$data = [
				'namaPemesan'         => $this->request->getPost('buyer'),
				'idProduk'            => $this->produk->getData(['uniqueCode' => $this->request->getPost('idProduk')], ['id']),
				'jumlah'              => $this->request->getPost('qty'),
				'tglPemesanan'        => $this->request->getPost('date'),
				'statusPembayaran'    => $this->request->getPost('paymentStatus'),
				'statusPemesanan'     => $this->request->getPost('orderStatus'),
			];

			// get produk id
			$idPesanan = $this->pesanan->getData(['uniqueCode' => $id], ['id']);

			// update produk
			$id = $this->pesanan->updateData($data, ['id' => $idPesanan]);

			if(!$id){
				session()->setFlashdata('message', 'Error');
			}
		}else {
			session()->setFlashdata('message', 'Error Validation');
		}

		return redirect()->to('/pesanan');
	}

	public function proses_delete($id){
        $cek = $this->pesanan->deleteData(['uniqueCode' => $id]);

        if(!$cek){
            return $this->response->setStatusCode(400);
        }else{
            return $this->response->setStatusCode(200);
        }
    }

}
