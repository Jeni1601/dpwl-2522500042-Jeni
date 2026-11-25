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
   2. Menambahkan method getDetailPelunasan(string $kodeSewa) pada berkas 
application\models\Pembayaran_model.php
   3. Menambahkan method internal buatKodeBayarPelunasan(string $tanggalKode) pada berkas application\models\Pembayaran_model.php
   4. Menambahkan method simpanPelunasan(string $kodeSewa, string $metodeBayar, ?string $namaFileBukti = null) pada berkas application\models\Pembayaran_model.php

# 5. 