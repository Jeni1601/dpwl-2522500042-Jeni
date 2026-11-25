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

F. 1. Membuat berkas application\views\admin\pelunasan.php, untuk menampilkan daftar transaksi yang masih memiliki kewajiban pembayaran. Menggunakan data daftarPelunasan yang dikirimkan application\controllers\Pembayaran_controller.ph
   2. Membuat application\views\admin\pelunasan_detail.php, untuk menampilkan detail transaksi yang akan dilunasi. Menggunakan data detailPelunasan yang dikirimkan application\controllers\Pembayaran_controller.php.

G. 1.Membuat berkas baru application\views\admin\dokumen_transaksi.php. View ini 
menerima data $detailPelunasan yang telah disiapkan oleh Model dan dikirimkan oleh method 
dokumenTransaksi() pada Controller di bagian D.

# 5. Daftar Berkas yang Ditambahkan atau Diubah
Berkas yang ditambahkan:
- application/views/admin/pelunasan.php – Menampilkan daftar transaksi yang masih memiliki kewajiban pembayaran.
- application/views/admin/pelunasan_detail.php – Menampilkan detail transaksi yang akan dilunasi.
- application/views/admin/dokumen_transaksi.php – Menampilkan dokumen transaksi yang dapat dicetak atau disimpan sebagai PDF.

Berkas yang Diubah:
- application/models/Pembayaran_model.php – Menambahkan fungsi untuk mengambil data pelunasan dan menyimpan pembayaran pelunasan.
- application/controllers/Pembayaran_controller.php – Menambahkan proses daftar pelunasan, detail pelunasan, proses pelunasan, dan dokumen transaksi.
- application/config/routes.php – Menambahkan route untuk mengakses fitur pelunasan dan dokumen transaksi.
- application/views/templates/sidebar.php – Menambahkan menu Pelunasan pada navigasi Admin.

# 6. Perubahan Struktur Basis Data
struktur basis data masih menggunakan struktur P9 dan tidak ada perubahan.

# 7. Hasil Pengujian Setiap Tahap
F.3 Menguji Tampilan dan Proses Pelunasan

G.2 Menguji Tampilan dan Cetak Dokumen Transaksi 
Seluruh pengujian pada tahap G.2 berhasil dilakukan dan berjalan sesuai dengan ketentuan modul P10.

# 8. Kendala, Proses Debugging, dan Perbaikan.
pada tahap menguji Tampilan dan Proses Pelunasan mengalami error 
Parse error: syntax error, unexpected token "<", expecting end of file in C:\laragon\www\dpwl_2522500042\application\config\routes.php on line 100, Error tersebut menunjukkan bahwa terdapat kesalahan sintaks PHP pada file: application/config/routes.php.
 Ada kode HTML yang tidak sengaja masuk ke dalam file routes.php, tepatnya pada bagian paling akhir:
<script type="module" src=""></script> Kode tersebut tidak seharusnya berada di dalam file konfigurasi route PHP. Itulah yang menyebabkan pesan unexpected token "<"
Perbaikannya :
Menghapus kode <script type="module" src=""></script> tersebut.
Agar lebih mudah, berikut kode routes.php lengkap yang sudah saya rapikan. Saya juga mempertahankan seluruh route P2 sampai P9 dan menambahkan route P10.
