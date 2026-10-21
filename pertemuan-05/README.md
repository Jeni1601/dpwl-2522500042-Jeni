# pertemuan-05
### Tahap A.5 – Dokumentasi dan Git

Pada tahap ini, saya memperbarui file README.md untuk mencatat perubahan yang dilakukan pada menu Manajemen Kendaraan. File yang diubah adalah `application/views/templates/sidebar.php` dan `application/config/routes.php`.

Pengujian dilakukan dengan menjalankan aplikasi dan mengeklik menu Manajemen Kendaraan. Hasil adalah URL berubah menjadi `admin/mobil`. Halaman kendaraan belum dapat ditampilkan karena Controller belum dibuat.

Perubahan selanjutnya dicatat menggunakan Git dan dikirim ke GitHub.

### B.3 Memperbarui README.md dan Mencatat Perubahan Git

Pada tahap ini, file `pertemuan-05/README.md` diperbarui untuk mencatat penambahan tiga route, yaitu `admin/mobil/tambah` untuk menambahkan data kendaraan, `admin/mobil/ubah/(:any)` untuk mengubah data kendaraan berdasarkan parameter nomor plat, dan `admin/mobil/hapus/(:any)` untuk menghapus data kendaraan berdasarkan parameter yang diberikan.

Berkas yang terdampak adalah `application/config/routes.php`, karena file tersebut digunakan untuk mengatur alamat URL dan menghubungkannya dengan method pada `Mobil_controller`. Setelah route ditambahkan, dilakukan pemeriksaan konfigurasi untuk memastikan penulisan route sudah sesuai dan tidak terjadi duplikasi. Hasil pemeriksaan kemudian dicatat dalam README sesuai kondisi yang benar-benar ditemukan.