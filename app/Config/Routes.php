<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// register
$routes->get('/register', 'Register');
$routes->post('/register/save', 'Register::save');

// login
$routes->get('/login', 'login');
$routes->post('/login', 'login::auth');
$routes->get('/logout', 'login::logout');

// dashboard
$routes->get('/', 'Dashboard');

// produk
$routes->get('/produk', 'Produk');
$routes->post('/produk/kategori', 'Produk::tambahKategori');

// bahan
$routes->get('/bahan', 'bahan');
$routes->post('/bahan/input', 'bahan::proses_insertDataBahan');
$routes->post('/bahan/edit/(:segment)', 'bahan::proses_editDataBahan/$1');
$routes->post('/bahan/delete/(:segment)', 'bahan::proses_deleteDataBahan/$1');
$routes->post('/bahan/kategori', 'bahan::proses_tambahKategoriBahan');

// stok bahan
$routes->get('/stokbahan', 'stokbahan');
$routes->post('/stokbahan/edit/(:segment)', 'stokbahan::update/$1');

// resep
$routes->get('/resep/(:segment)', 'Resep/$1');
$routes->get('/resep', 'Resep');
$routes->get('/resep/input', 'Resep::insert');

// pesanan
$routes->get('/pesanan', 'Pesanan');
$routes->post('/pesanan/input', 'Pesanan::proses_input');
$routes->post('/pesanan/delete/(:segment)', 'Pesanan::proses_delete/$1');
$routes->post('/pesanan/edit/(:segment)', 'Pesanan::proses_edit/$1');


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}