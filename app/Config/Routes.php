<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// admin
$routes->get('/petugas', 'Petugascontroller::index');
$routes->post('/petugas/login', 'Petugascontroller::login');
$routes->get('/petugas/dashboard', 'Petugascontroller::dashboard', ['filter' => 'otentifikasi']);
$routes->get('/petugas/logout', 'Petugascontroller::logout');

// crud kamar
$routes->get('/petugas/kamar', 'PetugasController::tampilkamar');
$routes->get('/petugas/kamar/tambah', 'PetugasController::tambahKamar');
$routes->post('/petugas/kamar/add', 'PetugasController::simpanKamar', ['filter' => 'otentifikasi']);
$routes->get('/petugas/kamar/detail/(:num)', 'PetugasController::tampildetailkamar/$1', ['filter' => 'otentifikasi']);
$routes->get('/petugas/kamar/edit/(:num)', 'PetugasController::editKamar/$1', ['filter' => 'otentifikasi']);
$routes->post('/petugas/kamar/update', 'PetugasController::updatekamar', ['filter' => 'otentifikasi']);
$routes->get('/petugas/kamar/hapus/(:num)', 'PetugasController::hapuskamar/$1', ['filter' => 'otentifikasi']);

// crud fasilitas kamar
$routes->get('/petugas/fkamar/tampil', 'PetugasController::tampilfkamar');
$routes->get('/petugas/fkamar/tambah', 'PetugasController::tambahFKamar');
$routes->post('/petugas/fkamar/add', 'PetugasController::simpanFKamar', ['filter' => 'otentifikasi']);
$routes->get('/petugas/kamar/detail/(:num)', 'PetugasController::tampildetailfkamar/$1', ['filter' => 'otentifikasi']);
$routes->get('/petugas/fkamar/edit/(:num)', 'PetugasController::editFKamar/$1', ['filter' => 'otentifikasi']);
$routes->post('/petugas/fkamar/update', 'PetugasController::updatefkamar', ['filter' => 'otentifikasi']);
$routes->get('/petugas/fkamar/hapus/(:num)', 'PetugasController::hapusfkamar/$1', ['filter' => 'otentifikasi']);

// crud fasilitas hotel
$routes->get('/petugas/fumum/tampil', 'PetugasController::tampilfumum');
$routes->get('/petugas/fumum/tambah', 'PetugasController::tambahFumum');
$routes->post('/petugas/fumum/add', 'PetugasController::simpanFumum', ['filter' => 'otentifikasi']);
$routes->get('/petugas/kamar/detail/(:num)', 'PetugasController::tampildetailfumum/$1', ['filter' => 'otentifikasi']);
$routes->get('/petugas/fumum/edit/(:num)', 'PetugasController::editFumum/$1', ['filter' => 'otentifikasi']);
$routes->post('/petugas/fumum/update', 'PetugasController::updatefumum', ['filter' => 'otentifikasi']);
$routes->get('/petugas/fumum/hapus/(:num)', 'PetugasController::hapusfumum/$1', ['filter' => 'otentifikasi']);

// crud tamu 
$routes->get('/fumum/tampil-fumum-tamu', 'PetugasController::tampilfumumtamu');
// crud Resepsionis 

$routes->get('/reservasi/dashboard-reservasi', 'reservasiController::dashboardreservasi');
$routes->get('/petugas/reservasi/data', 'reservasiController::tampilreservasi');
$routes->get('/petugas/reservasi/form', 'reservasiController::tampilreservasiform');
$routes->post('/petugas/reservasi/add', 'reservasiController::simpan');
$routes->get('/petugas/reservasi/cekin/(:num)', 'reservasiController::cekin/$1');
$routes->get('/petugas/reservasi/cekout/(:num)', 'reservasiController::cekout/$1');
$routes->get('/petugas/reservasi/edit/(:num)', 'reservasiController::edit/$1');
$routes->post('/petugas/reservasi/edit/(:num)', 'reservasiController::update/$1');
$routes->get('/petugas/reservasi/batal/(:num)', 'reservasiController::batal/$1');

// $routes->get('/petugas/reservasi/terima/(:num)', 'reservasiContrpller::terima$1');
// $routes->get('/petugas/reservasi/tolak/(:num)', 'reservasiContrpller::tolak$1');
// $routes->get('/petugas/reservasi/hapus/(:num)', 'reservasiContrpller::hapus');
$routes->get('/invoice/(:num)', 'ReservasiController::invoice/$1');

// user
$routes->post('/pesan', 'PesanController::pesan');

/*
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
