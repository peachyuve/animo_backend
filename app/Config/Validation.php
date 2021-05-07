<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	public $bahan = [
		'nama' => 'required',
		'idresep' => 'required',
		'kategori' => 'required',
		'satuan' => 'required',
		'subBahan' => 'required',
		'merk' => 'required',
		'suplier' => 'required',
		'linkSuplier' => 'required'
	];

	public $bahan_errors = [
		'nama' => [
			'required' => 'nama wajib diisi'
		],
		'idresep' => [
			'required' => 'idresep wajib diisi',
		],
		'kategori' => [
			'required' => 'kategori wajib diisi',
		],
		'satuan' => [
			'required' => 'satuan wajib diisi'
		],
		'subBahan' => [
			'required' => 'sub bahan wajib diisi'
		],
		'merk' => [
			'required' => 'merk wajib diisi'
		],
		'suplier' => [
			'required' => 'suplier wajib diisi'
		],
		'linkSuplier' => [
			'required' => 'linksuplier wajib diisi'
		]
	];
	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
