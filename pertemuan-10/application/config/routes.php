
<?php
// Nama Berkas - application/config/routes.php

$route = [];

// =====================================================
// ROUTE P2 / P3
// =====================================================

$route['default_controller'] = 'Katalog_controller';

$route['info/(:any)'] = 'Home/info/$1';

$route['login'] = 'Auth/login';
$route['auth/login'] = 'Auth/login';
$route['auth/logout'] = 'Auth/logout';

$route['admin'] = 'Admin/index';


// =====================================================
// ROUTE P4 - MANAJEMEN ADMIN
// =====================================================

$route['admin/madmin'] = 'Madmin_controller/index';
$route['admin/madmin/tambah'] = 'Madmin_controller/tambah';
$route['admin/madmin/ubah/(:any)'] = 'Madmin_controller/ubah/$1';
$route['admin/madmin/hapus/(:any)'] = 'Madmin_controller/hapus/$1';


// =====================================================
// ROUTE P5 - MANAJEMEN MOBIL
// =====================================================

$route['admin/mobil'] = 'Mobil_controller/index';
$route['admin/mobil/tambah'] = 'Mobil_controller/tambah';
$route['admin/mobil/ubah/(:any)'] = 'Mobil_controller/ubah/$1';
$route['admin/mobil/hapus/(:any)'] = 'Mobil_controller/hapus/$1';


// =====================================================
// ROUTE P6 - KATALOG DAN AKUN PENYEWA
// =====================================================

$route['katalog'] = 'Katalog_controller/index';
$route['katalog/detail/(:any)'] = 'Katalog_controller/detail/$1';

$route['auth/register'] = 'Auth/register';
$route['auth/login-penyewa'] = 'Auth/loginPenyewa';
$route['auth/logout-penyewa'] = 'Auth/logoutPenyewa';

$route['penyewa/profil'] = 'Penyewa_controller/profil';


// =====================================================
// ROUTE P7 - TRANSAKSI, KERANJANG, DAN CHECKOUT
// =====================================================

$route['transaksi/tambah'] = 'Transaksi_controller/tambah';
$route['transaksi/keranjang'] = 'Transaksi_controller/keranjang';
$route['transaksi/perbarui-periode'] = 'Transaksi_controller/perbaruiPeriode';

$route['transaksi/hapus'] = 'Transaksi_controller/hapus';
$route['transaksi/hapus/(:any)'] = 'Transaksi_controller/hapus/$1';

$route['transaksi/checkout'] = 'Transaksi_controller/checkout';


// =====================================================
// ROUTE P9 - PEMBAYARAN PENYEWA
// =====================================================

// Menampilkan daftar pembayaran penyewa
$route['pembayaran'] = 'Pembayaran_controller/index';

// Menampilkan detail pembayaran berdasarkan kode pembayaran
$route['pembayaran/detail/(:any)'] = 'Pembayaran_controller/detail/$1';

// Mengunggah foto bukti pembayaran
$route['pembayaran/upload-bukti/(:any)'] = 'Pembayaran_controller/uploadBukti/$1';


// =====================================================
// ROUTE P9 - VERIFIKASI PEMBAYARAN ADMIN
// =====================================================

// Menampilkan daftar pembayaran yang menunggu verifikasi
$route['admin/pembayaran'] = 'Pembayaran_controller/verifikasiIndex';

// Menampilkan detail pembayaran untuk admin
$route['admin/pembayaran/verifikasi/(:any)'] = 'Pembayaran_controller/verifikasiDetail/$1';

// Memproses keputusan verifikasi pembayaran
$route['admin/pembayaran/proses-verifikasi/(:any)'] = 'Pembayaran_controller/prosesVerifikasi/$1';

$route['admin/pembayaran/pelunasan'] = 'Pembayaran_controller/pelunasanIndex'; 
$route['admin/pembayaran/pelunasan/proses/(:any)'] = 'Pembayaran_controller/prosesPelunasan/$1'; 
$route['admin/pembayaran/dokumen/(:any)'] = 'Pembayaran_controller/dokumenTransaksi/$1'; 
$route['admin/pembayaran/pelunasan/(:any)'] = 'Pembayaran_controller/pelunasanDetail/$1';<script type="module" src=""></script>