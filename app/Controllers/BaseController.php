<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use App\Models\Bahan;
use App\Models\ProdukModel;
use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		// model
		$this->user = new \App\Models\userModel();
		$this->produk = new \App\Models\ProdukModel();
		$this->bahan = new \App\Models\Bahan();
		$this->porsi = new \App\Models\PorsiModel();
		$this->resep = new \App\Models\ResepModel();
		$this->pesanan = new \App\Models\PesananModel();
	}

	public function sendEmail($fromEmail, $from, $to, $subject=null, $message=null){
		session();
		$this->email->setFrom($fromEmail, $from);
		$this->email->setTo($to);

		$this->email->setSubject($subject);
		$this->email->setMessage($message);
    
 		return $this->email->send();
	}

	public function convertToSafeString($string)
	{
		$newString = [];

		if (gettype($string) == 'string') {
			$string = str_split($string);
			$newString = '';
			foreach ($string as $keyString => $valString) {
				$newString .= $this->sensitiveStringToSave($valString);
			}
		} 
		// elseif (count($string) == count($string, COUNT_RECURSIVE)) {
		// 	foreach ($string as $keyString => $valString) {
		// 		$tempSring = str_split($valString);
		// 		foreach ($tempSring as $keyTempSring => $valTempSring) {
		// 			$newString[$keyString] .= $this->sensitiveStringToSave($valString);
		// 		}
		// 	}
		// } else {
		// 	foreach ($string as $keyString => $valString) {
		// 		foreach ($valString as $keyValString => $valValString) {
		// 			$tempstring = str_split($valValString);
		// 			foreach ($tempstring as $keyTempstring => $valTempstring) {
		// 				$newString[$keyString][$keyValString] .= $this->sensitiveStringToSave($valString);
		// 			}
		// 		}
		// 	}
		// }

		return $newString;
	}

	private function sensitiveStringToSave($string)
	{
		switch ($string) {
			case "'":
				return "\'";
				break;

			default:
				return $string;
				break;
		}
	}
}
