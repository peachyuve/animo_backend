<?php namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\ResepModel;

class Resep extends BaseController
{
	public function index($idProduk = false)
	{
		// get produk list
		$idUser = $this->user->getData(['uniqueCode' => session()->get('id')], 'id');
		$produkArr = $this->produk->getProduks($idUser, 0, ['id', 'nama']);
		$bahanArr = $this->bahan->getData(['idUser' => $idUser], ['id', 'kategori']);
		if (!$idProduk) {
			$idProduk = $produkArr[0]['id'];
		}

		$resepArr = $this->resep->getResep($idUser, $idProduk, 0, ['subBahan', 'jumBahan', 
			'hargaBahan', 'hargaPerSatuan', 'ukuranResep', 
			'hargaTotal', 'totBiaya', 'jumPorsi', 'biayaSatuan']);
		
		$data = [
			'resep' => $resepArr,
			'produk' => $produkArr, 
			'bahan' => $bahanArr
		];
		
		print json_encode($data, JSON_PRETTY_PRINT);
		// return view('resep/resep',$data);
	}

	public function insert()
	{
		$langkah = $this->request->getGet('langkah');
		if ($langkah == 'bahan') {

			$namaProduk = $this->request->getPost('produk');
			$data['produkId'] = $this->produk->getData(['nama' => $namaProduk], 'id');

		}elseif ($langkah == 'data') {

			$data['produkId'] = $this->request->getPost('produkId');
			$namaSubbahan = $this->request->getPost('subbahan');
			$data['bahanId'] = $this->bahan->getData(['subbahan' => $namaSubbahan], 'id');

		}elseif ($langkah == 'porsi') {
			
			$data['produkId'] = $this->request->getPost('produkId');
			$data['bahanId'] = $this->request->getPost('bahanId');
			$data['jumBeli'] = $this->request->getPost('jumBeli');
			$data['hargaBeli'] = $this->request->getPost('hargaBeli');
			$data['ukuranResep'] = $this->request->getPost('ukuranResep');

		}

		$data['langkah'] = $langkah;
		return view('resep/insertresep', $data);
	}

	public function proses_insertDataResep()
	{
		$produkId       = $this->request->getPost('produkId');
		$bahanId        = $this->request->getPost('bahanId');
		$jumBeli        = $this->request->getPost('jumBeli');
		$hargaBeli      = $this->request->getPost('hargaBeli');
		$ukuranResep    = $this->request->getPost('ukuranResep');
		$jumPorsi       = $this->request->getPost('jumPorsi');

		if(gettype($bahanId) != 'array') $bahanId = [$bahanId];
		if(gettype($jumBeli) != 'array') $jumBeli = [$jumBeli];
		if(gettype($hargaBeli) != 'array') $hargaBeli = [$hargaBeli];
		if(gettype($ukuranResep) != 'array') $ukuranResep = [$ukuranResep];

		// hitung data setiap bahan
		$bahanData = [];
		foreach ($bahanId as $key => $val) {
			$bahanData = array_merge($bahanData, [[
				'idBahan' => $bahanId[$key],
				'jumBahan' => $jumBeli[$key],
				'hargaBahan' => $hargaBeli[$key],
				'hargaPerSatuan' => (
					$hargaBeli[$key]/$jumBeli[$key]
				),
				'ukuranResep' => $ukuranResep[$key],
				'hargaTotal' => (
					($hargaBeli[$key]/$jumBeli[$key]) * $ukuranResep[$key]
				),
				'idPorsi' => '',
			]]);
		}
		
		// hitung data per porsi
		$totalBiaya = 0;
		foreach ($bahanData as $key => $val) {
			$totalBiaya += $val['hargaTotal'];
		}

		$porsiData = [
			'idProduk' => $produkId,
			'jumPorsi' => $jumPorsi,
			'totBiaya' => $totalBiaya,
			'biayaSatuan' => (
				$totalBiaya/$jumPorsi
			),
		];

		// input porsi
		if ($idPorsi = $this->porsi->insertData($porsiData) ) {
			
			// input resep
			foreach ($bahanData as $key => $val) {
				$bahanData[$key]['idPorsi'] = $idPorsi;
				if ($idBahan = $this->resep->insertData($bahanData[$key])) {
				
				}else {
					$this->porsi->rollbackInsert($idPorsi);
					break;
				}
			}

		}

		return redirect()->to(base_url('resep'));
	}

	
}
