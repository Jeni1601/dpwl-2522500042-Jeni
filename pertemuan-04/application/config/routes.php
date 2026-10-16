<?php

$route = [];

$route['default_controller'] = 'home'; 
$route['info/(:any)'] = 'home/info/$1'; 

// Route autentikasi P3 
$route['login']       = 'auth/login'; 
$route['auth/login']  = 'auth/login'; 
$route['auth/logout'] = 'auth/logout'; 

// Route halaman administrasi 
$route['admin']       = 'admin/index'; 

// P4: BARU - semua proses CRUD admin dipindahkan di bawah /admin/madmin. 
$route['admin/madmin'] = 'Madmin_controller/index';
$route['admin/madmin/tambah'] = 'Madmin_controller/tambah';
$route['admin/madmin/ubah/(:any)'] = 'Madmin_controller/ubah/$1';
$route['admin/madmin/hapus/(:any)'] = 'Madmin_controller/hapus/$1';