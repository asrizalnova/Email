<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboardctrl');
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

$routes->get('login', 'Login::index');
$routes->post('login/process', 'Login::process');
$routes->get('logout', 'Login::logout');

$routes->get('admin/dashboard', 'admin\Dashboardctrl::index');

// $routes->get('admin/user/index', 'admin\Profil::index');

$routes->group('admin', ['filter' => 'filterDivisi'], function($routes) {
    $routes->get('pimpinan', 'admin\Pimpinanctrl::index');
    $routes->get('pimpinan/disposisi/(:num)', 'admin\Pimpinanctrl::disposisi/$1');
    $routes->get('pimpinan/divisi02/(:num)', 'admin\Pimpinanctrl::divisi02/$1');
    $routes->get('pimpinan/divisi03/(:num)', 'admin\Pimpinanctrl::divisi03/$1');
    $routes->post('pimpinan/reject', 'admin\Pimpinanctrl::reject');
    $routes->post('pimpinan/save-signature', 'admin\Pimpinanctrl::saveSignature');
    $routes->post('pimpinan/reset', 'admin\Pimpinanctrl::reset');
    $routes->post('pimpinan/save-response', 'admin\Pimpinanctrl::saveResponse');

    $routes->get('aktivitas/index', 'admin\Aktivitas::index', ['filter' => 'filterPimpinan']);
    $routes->get('aktivitas/tambah', 'admin\Aktivitas::tambah', ['filter' => 'filterPimpinan']);
    $routes->post('aktivitas/proses_tambah', 'admin\Aktivitas::proses_tambah', ['filter' => 'filterPimpinan']);
    $routes->get('aktivitas/edit/(:num)', 'admin\Aktivitas::edit/$1', ['filter' => 'filterPimpinan']);
    $routes->post('aktivitas/proses_edit/(:num)', 'admin\Aktivitas::proses_edit/$1', ['filter' => 'filterPimpinan']);
    $routes->get('aktivitas/delete/(:any)', 'admin\Aktivitas::delete/$1', ['filter' => 'filterPimpinan']);

    $routes->get('slider/index', 'admin\Slider::index', ['filter' => 'filterPimpinan']);
    $routes->get('slider/tambah', 'admin\Slider::tambah', ['filter' => 'filterPimpinan']);
    $routes->post('slider/proses_tambah', 'admin\Slider::proses_tambah', ['filter' => 'filterPimpinan']);
    $routes->get('slider/edit/(:num)', 'admin\Slider::edit/$1', ['filter' => 'filterPimpinan']);
    $routes->post('slider/proses_edit/(:num)', 'admin\Slider::proses_edit/$1', ['filter' => 'filterPimpinan']);
    $routes->get('slider/delete/(:any)', 'admin\Slider::delete/$1', ['filter' => 'filterPimpinan']);
    $routes->get('slider/update_status/(:num)', 'admin\Slider::updateStatus/$1', ['filter' => 'filterPimpinan']);
    $routes->get('slider/status', 'admin\Pimpinanctrl::status');


    $routes->get('produk/index', 'admin\Produk::index', ['filter' => 'filterPimpinan']);
    $routes->get('produk/tambah', 'admin\Produk::tambah', ['filter' => 'filterPimpinan']);
    $routes->post('produk/tambah', 'admin\Produk::proses_tambah', ['filter' => 'filterPimpinan']);
    $routes->get('produk/edit/(:num)', 'admin\Produk::edit/$1', ['filter' => 'filterPimpinan']);
    $routes->post('produk/proses_edit/(:num)', 'admin\Produk::proses_edit/$1', ['filter' => 'filterPimpinan']);
    $routes->get('produk/delete/(:any)', 'admin\Produk::delete/$1', ['filter' => 'filterPimpinan']);
    
});

// Email route
$routes->match(['get', 'post'], 'admin/email', 'SendEmail::index');

// Division routes
$routes->group('admin/divisi', function($routes) {
    $routes->get('awal', 'admin\Divisi::awal');
    $routes->get('index', 'admin\Divisi::index');
    $routes->get('lihat', 'admin\Divisi::divisi02');
    $routes->get('view', 'admin\Divisi::divisi03');
    $routes->post('proses_pengajuan', 'admin\Divisi::proses_pengajuan');
    $routes->post('tambah', 'admin\Divisi::tambah');
    $routes->post('pengajuan', 'admin\Divisi::pengajuan');
});

// Public routes
$routes->get('/', 'Search::index');
$routes->get('search/search', 'Search::search');
$routes->get('search/result', 'Search::search');

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
