# pertemuan-10
# 1. Identitas Mahasiswa
    Nama        : Jeni
    NIM         : 2522500042
    Kelompok    : SI3A  

# 2. Artefak dan Kondisi Awal Aplikasi P9
Pada P9, aplikasi penyewaan mobil telah memiliki fitur utama yang dikembangkan menggunakan PHP dengan konsep MVC dan database MySQL. Fitur yang sudah tersedia meliputi katalog mobil, manajemen kendaraan, manajemen penyewa, login dan autentikasi, keranjang penyewaan, checkout transaksi, manajemen pembayaran, serta upload bukti pembayaran DP.

# 3. Hasil Pemeriksaan Fitur P9
Pemeriksaan dilakukan terhadap fitur-fitur aplikasi P9 untuk memastikan seluruh fungsi berjalan dengan baik sebelum melanjutkan pengembangan P10. Pengujian meliputi login Admin dan Penyewa, katalog mobil, manajemen kendaraan, manajemen penyewa, keranjang penyewaan, checkout, proses pembayaran DP, serta upload bukti pembayaran.

# 4. Tahapan Pengembangan P10
A. Memperbarui dpwl-nim-nama\pertemuan-10\README.md, 
menyalin seluruh isi workspace dpwl-nim\ ke dpwl-nim-nama\pertemuan-10\

B. Mencari kolom status_sewa dan memeriksa tipe data serta nilai ENUM yang tersedia. Memastikan struktur awal kolom status_sewa.Setelah itu memastikan struktur awal kolom, menambahkan nilai lunas pada ENUM/SET editor untuk kolom status_sewa.  

C. 1. Menambahkan method getDaftarPelunasan() pada berkas application\models\Pembayaran_model.php
   2. Menambahkan method getDetailPelunasan(string $kodeSewa) pada berkas application\models\Pembayaran_model.php
   3. Menambahkan method internal buatKodeBayarPelunasan(string $tanggalKode) pada berkas application\models\Pembayaran_model.php
   4. Menambahkan method simpanPelunasan(string $kodeSewa, string $metodeBayar, ?string $namaFileBukti = null) pada berkas application\models\Pembayaran_model.php

D. 1. Menampilkan Daftar Transaksi yang Belum Lunas Method pelunasanIndex() pada berkas application\controllers\Pembayaran_controller.php 
   2. Menambahkan Method pelunasanDetail(string $kodeSewa) pada berkas application\controllers\Pembayaran_controller.php
   3. Menambahkan Method prosesPelunasan(string $kodeSewa) digunakan untuk mencatat pembayaran pelunasan yang diterima langsung oleh admin. pada berkas application\controllers\Pembayaran_controller.php
   4. Menambahkan Method dokumenTransaksi(string $kodeSewa) digunakan untuk menampilkan dokumen transaksi yang siap dicetak pada berkas application\controllers\Pembayaran_controller.php

E. 1. Menambahkan route sesuai method yang telah dibuat pada application\controllers\Pembayaran_controller.php pada berkas application\config\routes.php. 
   2. Menambahkan menu Pelunasan pada bagian navigasi admin, pada berkas  sidebar admin application\views\templates\sidebar.php. 

# 5. Daftar Berkas yang Ditambahkan atau Diubah
Berkas yang ditambahkan:

Berkas yang Diubah:
- application/models/Pembayaran_model.php – Menambahkan fungsi untuk mengambil data pelunasan dan menyimpan pembayaran pelunasan.
- application/controllers/Pembayaran_controller.php – Menambahkan proses daftar pelunasan, detail pelunasan, proses pelunasan, dan dokumen transaksi.
- application/config/routes.php – Menambahkan route untuk mengakses fitur pelunasan dan dokumen transaksi.
- application/views/templates/sidebar.php – Menambahkan menu Pelunasan pada navigasi Admin.

# 6. Perubahan Struktur Basis Data
struktur basis data masih menggunakan struktur P9 dan tidak ada perubahan.

# 7. Hasil Pengujian Setiap Tahap

# 8. Kendala, Proses Debugging, dan Perbaikan.

