<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/buku', 'Book::index');
$routes->get('/buku/tambah', 'Book::create');
$routes->post('/buku', 'Book::store');


$routes->get('/buku/(:num)', 'Book::show/$1');
$routes->get('/buku/(:num)/edit', 'Book::edit/$1');
$routes->post('/buku/(:num)', 'Book::update/$1');
$routes->post('buku/(:num)/hapus', 'Book::delete/$1');

$routes->get('/anggota', 'Member::index');
$routes->get('/anggota/tambah', 'Member::create');
$routes->post('/anggota', 'Member::store');
$routes->get('anggota/(:num)', 'Member::show/$1');
$routes->get('anggota/(:num)/edit', 'Member::edit/$1');
$routes->post('anggota/(:num)', 'Member::update/$1');
$routes->post('anggota/(:num)/hapus', 'Member::delete/$1');

$routes->get('riwayat', 'Loan::history');
$routes->get('peminjaman', 'Loan::index');
$routes->get('peminjaman/tambah', 'Loan::create');
$routes->post('peminjaman', 'Loan::store');
$routes->get('peminjaman/(:num)', 'Loan::show/$1');
