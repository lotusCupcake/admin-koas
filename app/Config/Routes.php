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
$routes->get('/manajemenAkun/', 'ManajemenAkun::index', ['filter' => 'role:Superadmin']);
$routes->get('/manajemenAkun/index', 'ManajemenAkun::index', ['filter' => 'role:Superadmin']);
$routes->delete('/manajemenAkun/(:num)', 'ManajemenAkun::delete/$1');
$routes->add('/manajemenAkun/(:num)/edit', 'ManajemenAkun::edit/$1');

// route maintenance
$routes->get('/maintenance/(:any)', 'Maintenance::index');

// route data rumah sakit
$routes->get('/dataRumahSakit/', 'DataRumahSakit::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->get('/dataRumahSakit/index', 'DataRumahSakit::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->post('/dataRumahSakit', 'DataRumahSakit::add');
$routes->delete('/dataRumahSakit/(:num)', 'DataRumahSakit::delete/$1');
$routes->add('/dataRumahSakit/(:num)/edit', 'DataRumahSakit::edit/$1');

// route stase rumah sakit
$routes->get('/staseRumahSakit/', 'StaseRumahSakit::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->get('/staseRumahSakit/index', 'StaseRumahSakit::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->post('/staseRumahSakit', 'StaseRumahSakit::add');
$routes->delete('/staseRumahSakit/(:num)', 'StaseRumahSakit::delete/$1');
$routes->add('/staseRumahSakit/(:num)/edit', 'StaseRumahSakit::edit/$1');

// route data bagian
$routes->get('/stase/', 'Stase::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->get('/stase/index', 'Stase::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->post('/stase', 'Stase::add');
$routes->delete('/stase/(:num)', 'Stase::delete/$1');
$routes->add('/stase/(:num)/edit', 'Stase::edit/$1');

// route dosen pembimbing
$routes->get('/dosenPembimbing/', 'DosenPembimbing::index', ['filter' => 'role:Superadmin,Admin Prodi,Koordik']);
$routes->get('/dosenPembimbing/index', 'DosenPembimbing::index', ['filter' => 'role:Superadmin,Admin Prodi,Koordik']);
$routes->post('/dosenPembimbing', 'DosenPembimbing::add');
$routes->delete('/dosenPembimbing/(:num)', 'DosenPembimbing::delete/$1');
$routes->add('/dosenPembimbing/(:num)/edit', 'DosenPembimbing::edit/$1');

// route data kelompok
$routes->get('/dataKelompok/', 'DataKelompok::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->get('/dataKelompok/index', 'DataKelompok::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->post('/dataKelompok', 'DataKelompok::add');
$routes->delete('/dataKelompok/(:num)', 'DataKelompok::delete/$1');
$routes->add('/dataKelompok/(:num)/edit', 'DataKelompok::edit/$1');
$routes->post('/tambahPartisipan', 'DataKelompok::tambahPartisipan');

// route kelompok mahasiswa
$routes->get('/kelompokMahasiswa/', 'KelompokMahasiswa::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->get('/kelompokMahasiswa/index', 'KelompokMahasiswa::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->delete('/kelompokMahasiswa/(:num)', 'KelompokMahasiswa::delete/$1');

// route mahasiswa profesi
$routes->get('/mahasiswaProfesi/', 'MahasiswaProfesi::index', ['filter' => 'role:Superadmin,Admin Prodi,Dosen,Koordik']);
$routes->get('/mahasiswaProfesi/index', 'MahasiswaProfesi::index', ['filter' => 'role:Superadmin,Admin Prodi,Dosen,Koordik']);

// route jadwal kegiatan
$routes->get('/jadwalKegiatan/', 'JadwalKegiatan::index', ['filter' => 'role:Superadmin,Admin Prodi, Koordik']);
$routes->get('/jadwalKegiatan/index', 'JadwalKegiatan::index', ['filter' => 'role:Superadmin,Admin Prodi, Koordik']);
$routes->get('/jadwalKegiatan/stase', 'JadwalKegiatan::stase');
$routes->get('/jadwalKegiatan/kelompok', 'JadwalKegiatan::kelompok');
$routes->post('/jadwalKegiatan', 'JadwalKegiatan::add');
$routes->add('/jadwalKegiatan/(:num)/edit', 'JadwalKegiatan::edit/$1');
$routes->delete('/jadwalKegiatan/(:num)', 'JadwalKegiatan::delete/$1');

// route doata kegiatan
$routes->get('/dataKegiatan/', 'DataKegiatan::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->get('/dataKegiatan/index', 'DataKegiatan::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->post('/dataKegiatan', 'DataKegiatan::add');
$routes->delete('/dataKegiatan/(:num)', 'DataKegiatan::delete/$1');
$routes->add('/dataKegiatan/(:num)/edit', 'DataKegiatan::edit/$1');

// route panduan
$routes->get('/panduan/', 'Panduan::index', ['filter' => 'role:Superadmin,Admin Prodi,Dosen,Koordik']);
$routes->get('/panduan/index', 'Panduan::index', ['filter' => 'role:Superadmin,Admin Prodi,Dosen,Koordik']);
$routes->post('/panduan', 'Panduan::add');
$routes->delete('/panduan/(:num)', 'Panduan::delete/$1');
$routes->add('/panduan/(:num)/edit', 'Panduan::edit/$1');

// route kegiatan
$routes->get('/kegiatanMahasiswa/', 'KegiatanMahasiswa::index', ['filter' => 'role:Superadmin,Admin Prodi,Dosen,Koordik']);
$routes->get('/kegiatanMahasiswa/index', 'KegiatanMahasiswa::index', ['filter' => 'role:Superadmin,Admin Prodi,Dosen,Koordik']);
$routes->add('/kegiatanMahasiswa/(:num)/setujui', 'KegiatanMahasiswa::setujui/$1');

// route Absensi
$routes->get('/kegiatanMahasiswa/', 'KegiatanMahasiswa::index', ['filter' => 'role:Superadmin,Admin Prodi, Koordik']);
$routes->get('/kegiatanMahasiswa/index', 'KegiatanMahasiswa::index', ['filter' => 'role:Superadmin,Admin Prodi, Koordik']);

// route Folow Up
$routes->get('/followUp/(:any)', 'FollowUp::index');
$routes->add('/followUp/(:num)/setujui', 'FollowUp::setujui/$1');

// route penilaian
$routes->get('/penilaian/(:any)', 'Penilaian::index');

// route cetak laporan
$routes->get('/report/(:any)', 'Report::index/$1');

//route utilitas
$routes->get('/utilitas/', 'Utilitas::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->get('/utilitas/index', 'Utilitas::index', ['filter' => 'role:Superadmin,Admin Prodi']);
$routes->post('/pengumuman', 'Utilitas::pengumumanAdd');
$routes->delete('/pengumuman/(:num)', 'Utilitas::pengumumanDelete/$1');
$routes->add('/pengumuman/(:num)/edit', 'Utilitas::pengumumanEdit/$1');

//route rekap absen
$routes->get('/rekapAbsen/(:any)', 'RekapAbsen::index');
$routes->post('/rekapAbsen/proses', 'RekapAbsen::proses');
$routes->post('/rekapAbsen/cetak', 'RekapAbsen::exportRekapAbsen');


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
