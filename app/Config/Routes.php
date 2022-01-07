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

// route home
$routes->get('/home/(:any)', 'Home::index');

// route mamajemen user
$routes->get('/manajemenAkun/(:any)', 'ManajemenAkun::index');
$routes->delete('/manajemenAkun/(:num)', 'ManajemenAkun::delete/$1');
$routes->add('/manajemenAkun/(:num)/edit', 'ManajemenAkun::edit/$1');

// route maintenance
$routes->get('/maintenance/(:any)', 'Maintenance::index');

// route data rumah sakit
$routes->get('/dataRumahSakit/(:any)', 'DataRumahSakit::index');
$routes->post('/dataRumahSakit', 'DataRumahSakit::add');
$routes->delete('/dataRumahSakit/(:num)', 'DataRumahSakit::delete/$1');
$routes->add('/dataRumahSakit/(:num)/edit', 'DataRumahSakit::edit/$1');

// route stase rumah sakit
$routes->get('/staseRumahSakit/(:any)', 'StaseRumahSakit::index');
$routes->post('/staseRumahSakit', 'StaseRumahSakit::add');
$routes->delete('/staseRumahSakit/(:num)', 'StaseRumahSakit::delete/$1');
$routes->add('/staseRumahSakit/(:num)/edit', 'StaseRumahSakit::edit/$1');

// route data bagian
$routes->get('/dataBagian/(:any)', 'DataBagian::index');
$routes->post('/dataBagian', 'DataBagian::add');
$routes->delete('/dataBagian/(:num)', 'DataBagian::delete/$1');
$routes->add('/dataBagian/(:num)/edit', 'DataBagian::edit/$1');

// route dosen pembimbing
$routes->get('/dosenPembimbing/(:any)', 'DosenPembimbing::index');
$routes->post('/dosenPembimbing', 'DosenPembimbing::add');
$routes->delete('/dosenPembimbing/(:num)', 'DosenPembimbing::delete/$1');
$routes->add('/dosenPembimbing/(:num)/edit', 'DosenPembimbing::edit/$1');

// route jadwal kegiatan
$routes->get('/jadwalKegiatan/(:any)', 'JadwalKegiatan::index');
$routes->get('/jadwalKegiatan/stase', 'JadwalKegiatan::stase');
$routes->get('/jadwalKegiatan/kelompok', 'JadwalKegiatan::kelompok');
$routes->post('/jadwalKegiatan', 'JadwalKegiatan::add');


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
