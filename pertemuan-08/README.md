# pertemuan-08
A. Persiapan Folder Proyek untuk GitHub

Pada tahap awal persiapan UTS Pertemuan 8, saya memindahkan folder proyek dpwl-nim ke dalam folder baru yang bernama dpwl-nim-nama. Pemindahan ini dilakukan untuk menyesuaikan lokasi dan penamaan folder proyek yang akan digunakan dalam proses pengelolaan serta pengumpulan tugas melalui GitHub.

### 1. Penambahan Menu Manajemen Penyewa

Pada tahap ini, saya menambahkan menu **Manajemen Penyewa** pada bagian navigasi Admin. Penambahan menu ini bertujuan agar Admin dapat mengakses fitur pengelolaan data penyewa dengan lebih mudah.

Menu Manajemen Penyewa ditambahkan pada bagian sidebar AdminLTE, sejajar dengan menu Dashboard, Manajemen Admin, dan Manajemen Kendaraan. Saya juga menambahkan ikon pengguna agar menu lebih mudah dikenali.

Selain itu, saya menambahkan route `admin/penyewa` pada file `application/config/routes.php` yang diarahkan ke `Penyewa_controller`. Route ini nantinya digunakan untuk mengakses halaman Manajemen Penyewa

Setelah penambahan kode selesai, saya melakukan pemeriksaan pada halaman Admin untuk memastikan menu Manajemen Penyewa sudah muncul pada navigasi dan memiliki tautan menuju halaman yang sesuai.

**Hasil:** Menu Manajemen Penyewa berhasil ditambahkan pada navigasi Admin dan siap digunakan untuk melanjutkan pengembangan fitur pengelolaan data penyewa.