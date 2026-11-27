# pertemuan-11
# P11 – Pemenuhan atau Penyerahan Objek Transaksi dengan MVC 
## A. Dokumentasi Persiapan Baseline P10 
### A.1. Workspace dan Artefak P10 
Artefak P10 telah disalin ke workspace `dpwl-nim\` sebagai dasar pengembangan P11. Pengembangan 
dilakukan secara kumulatif dengan mempertahankan struktur dan fitur aplikasi sebelumnya. 

### A.2. Struktur Aplikasi dan Basis Data 
Struktur aplikasi homemade MVC dan basis data MySQL telah diperiksa. Tabel yang digunakan dalam 
pengembangan P11 meliputi `t_sewa`, `t_pilih`, `t_mobil`, `t_bayar`, dan `t_penyewa`.

### A.3. Pemeriksaan Fitur P10 
Fitur transaksi dan pembayaran P10 telah diperiksa melalui aplikasi. Hasil pemeriksaan: - semua fitur pada P10 berhasil diuji. - Tidak ada kendala yang ditemukan. - Tidak ada perbaikan yang dilakukan.

### A.4. Dokumentasi dan Repositori Git 
Dokumentasi P11 disiapkan pada `pertemuan-11\README.md`. Hasil pekerjaan disimpan dalam direktori 
`pertemuan-11` dan dikelola menggunakan Git. 

## B. Analisis Persyaratan Serah Terima Kendaraan 
P11 mengembangkan proses serah terima kendaraan setelah transaksi disetujui dan pembayaran DP 
diverifikasi valid. Sebelum penyerahan dikonfirmasi, admin harus memastikan data penyewa, dokumen 
KTP dan SIM A, serta detail kendaraan tersedia. 
Proses serah terima menggunakan tabel `t_sewa`, `t_bayar`, `t_penyewa`, `t_pilih`, dan `t_mobil`. 
Sistem mencatat waktu aktual penyerahan pada `t_sewa.wkt_ambil` dan mengubah `t_sewa.status_sewa` 
menjadi `aktif`. Status kendaraan tetap `disewa` dan tidak dibuat pembayaran baru. 
Implementasi direncanakan menggunakan pemisahan tanggung jawab MVC: Model mengelola pengambilan dan 
penyimpanan data, Controller menangani alur permintaan dan validasi proses, sedangkan View 
menyajikan informasi serta formulir serah terima. 
Analisis ini menjadi dasar implementasi pada bagian C sampai dengan F.

# C. Mengimplementasikan Model Serah Terima pada application\models\SerahTerima_model.php
## C.1. Menginisialisasi Koneksi Basis Data MySQLi 
Model membutuhkan koneksi basis data untuk menjalankan kueri. Pada aplikasi DPWL, koneksi MySQLi telah 
tersedia melalui variabel global $db. Membuat berkas baru application\models\SerahTerima_model.php

## C.2. Mengambil Daftar Transaksi yang Memenuhi Syarat Serah Terima
Menambahkan method getDaftarSerahTerima() setelah konstruktor

## C.3. Mengambil Detail Transaksi, Pembayaran, Penyewa, dan Kendaraan
Menambahkan method getDetailSerahTerima() Method tersebut menerima $kodeSewa sebagai parameter dan melakukan pemeriksaan agar kode transaksi tidak kosong.
Menambahkan method getDaftarKendaraan() Method privat tersebut menghubungkan tabel t_pilih dengan t_mobil menggunakan kolom no_plat

## C.4. Mengintegrasikan Data Menggunakan Kueri Lintas Tabel dan Prepared Statement 
## C.5. Memvalidasi Persyaratan dan Memproses Serah Terima Kendaraan 
Menambahkan method prosesSerahTerima() pada class SerahTerima_model pada berkas 
application\models\SerahTerima_model.php 

### C. Implementasi Model Serah Terima
Membuat `application/models/SerahTerima_model.php` untuk mengelola pengambilan daftar dan detail 
transaksi serah terima serta pemrosesan penyerahan kendaraan. Model menggunakan MySQLi, prepared 
statement, kueri lintas tabel, validasi persyaratan transaksi, dan transaksi basis data. 
 
Proses serah terima memeriksa status transaksi, validitas pembayaran DP, kelengkapan dokumen KTP dan 
SIM A, serta keberadaan kendaraan. Jika seluruh persyaratan terpenuhi, sistem mencatat waktu aktual 
pengambilan dan mengubah status transaksi menjadi `aktif`. Status kendaraan tetap `disewa`. 
 
Pengujian fungsional Model: dilanjutkan setelah integrasi Controller, route, dan View.  