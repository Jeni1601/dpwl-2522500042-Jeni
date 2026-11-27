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

## D. Implementasi Controller Daftar Serah Terima 
### D.1. Menangani Permintaan Daftar Transaksi Serah Terima 
Method `index()` dibuat untuk menangani permintaan daftar transaksi yang siap diserahterimakan. 
Controller mengambil data melalui `getDaftarSerahTerima()` pada Model dan meneruskannya kepada View. 
Akses dibatasi untuk admin dengan metode HTTP GET. 

### D.2. Menangani Permintaan Detail Transaksi Serah Terima 
Method `detail()` dibuat untuk menangani permintaan detail transaksi berdasarkan kode sewa. Data 
transaksi, penyewa, pembayaran, dan kendaraan diambil melalui `getDetailSerahTerima()` pada Model. 

### D.3. Menangani Proses Konfirmasi Serah Terima Kendaraan 
Method `proses()` dibuat untuk menangani konfirmasi serah terima menggunakan metode POST. Controller 
memproses unggahan dokumen, mencatat waktu aktual pengambilan, memanggil Model, serta menangani 
hasil proses dan pesan kepada admin.

### D.4. Memvalidasi Status Transaksi, Pembayaran, dan Persyaratan Serah Terima 
Controller memanggil Model untuk memproses validasi status transaksi, pembayaran DP, dokumen KTP dan 
SIM A, serta keberadaan kendaraan. Jika persyaratan tidak terpenuhi, proses dibatalkan dan pesan 
kegagalan disampaikan kepada admin. 

### D.5. Menerapkan Validasi, Sanitasi, dan Pengendalian Akses
Controller menerapkan pembatasan akses admin, pemeriksaan metode HTTP, serta validasi unggahan 
dokumen KTP dan SIM A. Dokumen yang diterima berupa JPEG, PNG, atau WEBP dengan ukuran maksimal 5 
MB. 
Controller menyediakan method `hapusSatuFile()` untuk membatasi penghapusan berkas hanya pada 
dokumen KTP dan SIM A yang dibuat oleh mekanisme unggah P11. Method `hapusFileBaru()` digunakan 
untuk membersihkan dokumen baru apabila proses serah terima gagal, sedangkan `hapusFileLama()` 
digunakan untuk menghapus dokumen lama setelah dokumen penggantinya berhasil disimpan. 
 
Mekanisme ini membantu menjaga konsistensi berkas dokumen dan mencegah penghapusan berkas di luar 
cakupan unggahan P11.

### D.6. Menerapkan Pola Post-Redirect-Get (PRG) 
Controller menerapkan pola Post-Redirect-Get (PRG) dengan menyimpan pesan sementara pada session dan 
mengarahkan admin ke halaman tujuan. Pesan ditampilkan satu kali setelah pengalihan.

### D.7. Mencegah Pemrosesan Ulang Serah Terima 
Model menerapkan penguncian transaksi dan pemeriksaan status sebelum memproses serah terima. 
Transaksi yang sudah berubah menjadi aktif tidak dapat diproses kembali.

### D.8 Implementasi Controller Serah Terima 
Controller `SerahTerima_controller.php` dibuat untuk menangani permintaan daftar transaksi, detail 
transaksi, dan konfirmasi serah terima kendaraan.
Controller diintegrasikan dengan `SerahTerima_model` serta menerapkan pengendalian akses admin, 
pembatasan metode HTTP, validasi unggahan dokumen, dan pola Post-Redirect-Get (PRG). 
 
Pemeriksaan implementasi dilakukan dengan memastikan setiap method Controller menggunakan method 
Model yang sesuai. Pengujian fungsional melalui browser dilaksanakan setelah integrasi Route, View, 
dan Controller selesai.