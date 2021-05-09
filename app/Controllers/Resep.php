<?php namespace App\Controllers;

class Resep extends BaseController
{
	public function index()
	{

		// $this->session->destroy(); // hanya untuk test logout
		// if (isset($this->session->islogin)) {
		return $this->Resep();
		// }else {
		// 	echo "Login Dulu";
		// }
		
	}
	public function Resep()
	{
		$this->session->set('islogin','Login'); // hanya untuk test login
		$this->session->set('uniqueCode','asd');// hanya untuk test login
		$this->session->set('id','3');// hanya untuk test login
		$this->session->set('user','RIvan'); // hanya untuk test login
		$uniq = $this->session->id;
		$idProduk = 1;
		$data['namaproduk'] = $this->Resep->GetProduct(['uniqueCode','nama'],$uniq);
		$data['GetBahanBaku'] = $this->Resep->GetBahanBaku(['nama', 'satuan', 'kategori','merk'],$uniq);
		$data['viewResep'] = $this->Resep->viewResep(['subBahan', 'jumBahan', 'hargaBahan', 'hargaPerSatuan', 'ukuranResep'],$uniq,$idProduk);
		$data['listSubBahan'] = $this->Resep->GetBahanBaku(['subBahan'],$uniq);
		$data['Porsi'] = $this->Resep->GetPorsi(['jumPorsi'],$uniq,1);
		// print_r($data['Porsi']);
		// $data_porsi = [
        //     'jumPorsi' => 3,
        //     'idProduk' => 1,
        // ];
		// $data['Porsi'] = $this->Bahan->insertData($data_porsi);
		// $idPorsi = $data['Porsi'];
		// $data_resep = [
		// 	'idPorsi' => $idPorsi,
		// 	'ukuranResep' => 5,
		// ];
		// $data['Resep'] = $this->Test->insertData($data_resep);
		// $idResep = $data['Resep'];
		// $data_resepDetail = [
		// 	'idResep' => $idResep,
		// 	'idBahan' => 1,
		// 	'jumBahan' => 10,
		// 	'hargaBahan' => 5,
		// 	'hargaPerSatuan' => 10/5,
			
		// ];
		// $data['resepdetail'] = $this->Test2->insertData($data_resepDetail);
		// $idResepdetail = $data['resepdetail'];

		// print_r($idResepdetail);
		
		// print_r($data['listSubBahan']);
		return view('resep',$data);
	}


	public function proses_insertDataResep(){
        $this->helpers = ['form', 'url'];
        $data_porsi = [
            'jumPorsi' => $this->request->getPost('jumPorsi'),
            'idProduk' => $this->request->getPost('idProduk'),
        ];
        $id = $this->Porsi->insertData($data_porsi);
        if(!$id){
            $this->session->set_flashdata('message', 'Error');
        }else{
            $data_resep = [
                'idPorsi' => $id,
                'ukuranResep' => $this->request->getPost('ukuranResep'),
            ];
            $id = $this->Resep->insertData($data_resep);
            if(!$id){
                $this->session->set_flashdata('message', 'Error');
            }else{
                $data_resepDetail = [
					'idResep' => $id,
					'idBahan' => $this->request->getPost('idBahan'),
					'jumBahan' => $this->request->getPost('jumBahan'),
					'hargaBahan' => $this->request->getPost('hargaBahan'),
					'hargaPerSatuan' => ((int)$this->request->getPost('hargaBahan')) / ((int)$this->request->getPost('jumBahan')),
                ];
				$id = $this->resep_detail->insertData($data_resepDetail);
        	}
		}
    }

	
}
