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

// route maintenance
$routes->get('/maintenance/(:any)', 'Maintenance::index');

// route data rumah sakit
$routes->get('/dataRumahSakit/(:any)', 'DataRumahSakit::index');

// route data bagian
$routes->get('/dataBagian/(:any)', 'DataBagian::index');
$routes->post('/dataBagian', 'DataBagian::add');
$routes->delete('/dataBagian/(:num)', 'DataBagian::delete/$1');
$routes->add('/dataBagian/(:num)/edit', 'DataBagian::edit/$1');

// route data bagian
$routes->get('/dosenPembimbing/(:any)', 'DosenPembimbing::index');

// route jadwal kegiatan
$routes->get('/jadwal/(:any)', 'Jadwal::index');
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
