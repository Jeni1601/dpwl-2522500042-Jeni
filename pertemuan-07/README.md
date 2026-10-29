# pertemuan-07
### A.2. Menyimpan Hasil Praktikum dan Memperbarui Git

**Hasil Pengujian**

Pada tahap A.2, aplikasi DPWL hasil pengembangan P6 diperiksa untuk memastikan aplikasi siap digunakan sebagai dasar pengembangan P7. Pengujian dilakukan dengan menjalankan aplikasi melalui Laragon dan membuka aplikasi menggunakan browser.

| No. | Skenario Pengujian | Hasil Pengujian | Status |
|---|---|---|---|
| 1 | Menjalankan aplikasi melalui Laragon. | Aplikasi berhasil dijalankan dan dapat diakses melalui browser. | Berhasil |
| 2 | Memeriksa koneksi basis data. | Koneksi basis data berjalan dengan baik. | Berhasil |
| 3 | Menguji fitur login admin dan penyewa. | Fitur autentikasi dapat digunakan dengan baik. | Berhasil |
| 4 | Menguji halaman katalog dan detail kendaraan. | Halaman katalog dan detail kendaraan dapat ditampilkan dengan baik. | Berhasil |
| 5 | Memeriksa pengelolaan kendaraan beserta fotonya. | Fitur pengelolaan kendaraan dapat digunakan tanpa galat. | Berhasil |
| 6 | Memeriksa halaman profil penyewa. | Halaman profil penyewa dapat dibuka dengan baik. | Berhasil |

**Kesimpulan**

Berdasarkan hasil pengujian, aplikasi DPWL hasil pengembangan P6 siap digunakan sebagai dasar pengembangan P7. Fitur-fitur utama yang telah dibuat pada P6 dapat berjalan dengan baik. Selanjutnya, hasil praktikum didokumentasikan dalam `README.md`, disalin ke folder `pertemuan-07`, kemudian disimpan ke repositori GitHub menggunakan proses commit dan push.


## B.1 Membuat Model Transaksi

### Hasil Pengujian

| No. | Pengujian | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|
| 1 | Memeriksa file `Transaksi_model.php` | File berhasil dibuat pada folder `application/models/`. | File Model transaksi tersedia. |
| 2 | Memeriksa koneksi basis data | Model dapat menggunakan koneksi MySQLi dari variabel `$db`. | Koneksi digunakan melalui properti `$this->db`. |
| 3 | Memeriksa method `ambilKunci()` | Model dapat meminta kunci proses ke basis data untuk mengendalikan akses bersamaan. | Method disiapkan untuk mengatur kunci proses. |
| 4 | Memeriksa method `lepasKunci()` | Kunci proses dapat dilepaskan setelah digunakan. | Method disiapkan untuk melepaskan kunci proses. |
| 5 | Memeriksa method `kunciDanBuatKodeSewa()` | Model menyiapkan kode transaksi dengan nomor urut dan perlindungan terhadap pembuatan kode secara bersamaan. | Method disiapkan untuk menghasilkan kode transaksi. |
| 6 | Menguji penambahan kendaraan ke keranjang | Kendaraan tersimpan pada tabel `t_sewa` dan `t_pilih`. | Belum diuji pada tahap B.1 karena proses penambahan kendaraan ke keranjang belum diimplementasikan secara lengkap. |

### Kesimpulan

Pada tahap B.1, Model transaksi dibuat sebagai fondasi untuk pengelolaan transaksi penyewaan kendaraan. Model menggunakan koneksi MySQLi serta menyediakan mekanisme penguncian proses untuk membantu mencegah benturan saat kode transaksi dibuat. Fitur penambahan kendaraan ke keranjang belum diuji pada tahap ini karena masih memerlukan integrasi Controller, route, dan proses penambahan kendaraan pada tahap berikutnya.