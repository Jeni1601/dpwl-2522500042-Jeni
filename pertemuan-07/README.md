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

### B.2. Membuat Controller Transaksi

Pada tahap ini, saya membuat file `application/controllers/Transaksi_controller.php` yang berfungsi untuk mengatur proses transaksi penyewaan kendaraan, khususnya ketika penyewa ingin menambahkan kendaraan ke keranjang.

Controller ini menggunakan `Transaksi_model.php` untuk menghubungkan proses permintaan dengan pengolahan data transaksi. Beberapa fungsi yang diterapkan yaitu:

1. **__construct()**: Menginisialisasi Model transaksi agar dapat digunakan oleh Controller.
2. **tambah()**: Memproses permintaan penambahan kendaraan ke keranjang dengan metode POST.
3. **wajibLoginPenyewa()**: Memastikan pengguna sudah login sebagai penyewa sebelum melakukan transaksi.
4. **wajibMetode()**: Memastikan permintaan menggunakan metode HTTP yang sesuai, yaitu POST.
5. **redirectTambahDenganPesan()**: Mengarahkan penyewa kembali ke halaman katalog atau detail kendaraan dengan membawa pesan berhasil atau gagal.
6. **pesanBisnisAman()**: Mengatur pesan kesalahan agar informasi yang ditampilkan kepada pengguna tetap aman dan mudah dipahami.

**Hasil Pengujian:**

Pada tahap ini, Controller transaksi berhasil dibuat sesuai dengan instruksi modul. Namun, pengujian fungsional penambahan kendaraan melalui halaman katalog belum dilakukan karena masih membutuhkan integrasi Model, Route, dan formulir katalog pada tahap berikutnya.

Pengujian penambahan kendaraan ke keranjang akan dilakukan setelah seluruh komponen tersebut terintegrasi.

## B.3. Menambahkan Route Transaksi

Pada tahap ini, saya menambahkan route transaksi pada file application/config/routes.php. Route ini digunakan untuk menghubungkan URL transaksi/tambah dengan method tambah() yang terdapat pada Transaksi_controller.

Kode route yang ditambahkan adalah:

// Route P7 - Transaksi dan Keranjang
$route['transaksi/tambah'] = 'Transaksi_controller/tambah';

Route tersebut berfungsi untuk menerima permintaan dari formulir penambahan kendaraan ke keranjang. Permintaan dikirim menggunakan metode POST dan selanjutnya diproses oleh method tambah() pada Transaksi_controller.

Hasil Pengujian:

Pada tahap ini, route transaksi berhasil ditambahkan ke dalam file routes.php sesuai dengan instruksi modul. Route sudah disiapkan untuk menghubungkan URL transaksi/tambah dengan Controller transaksi.

Namun, fitur penambahan kendaraan ke keranjang belum dapat diuji secara fungsional karena formulir pada halaman katalog dan halaman detail kendaraan belum diintegrasikan. Pengujian tersebut akan dilakukan pada tahap berikutnya setelah formulir, Controller, dan Model terhubung.

## C.1. Mengubah Formulir pada Halaman Detail Kendaraan

Pada tahap ini, saya melakukan perubahan pada file `application/views/katalog/detail.php`, khususnya pada bagian formulir **Add To Cart**. Perubahan ini bertujuan agar penyewa dapat menambahkan kendaraan ke keranjang melalui halaman detail kendaraan.

Formulir yang sebelumnya menggunakan metode GET diubah menjadi metode **POST** dan diarahkan ke route `transaksi/tambah`. Data nomor polisi kendaraan dikirim melalui input tersembunyi (`no_plat`), sedangkan `return_to` digunakan untuk menentukan halaman asal setelah proses penambahan kendaraan dilakukan.

Tampilan tombol disesuaikan dengan kondisi kendaraan dan status login penyewa, yaitu:

1. **Penyewa belum login:** Sistem menampilkan informasi agar penyewa melakukan login atau registrasi, serta menyediakan tombol Login Penyewa dan Registrasi.
2. **Kendaraan tidak tersedia:** Sistem menampilkan pesan bahwa kendaraan tidak dapat ditambahkan ke keranjang.
3. **Penyewa sudah login:** Sistem menampilkan tombol Tambah ke Keranjang yang mengirim data kendaraan menggunakan metode POST ke route `transaksi/tambah`.

**Hasil Pengujian:**

Pengujian dilakukan melalui halaman detail kendaraan pada aplikasi localhost dengan beberapa kondisi berikut:

1. Saat belum login sebagai penyewa, sistem menampilkan informasi login serta tombol Login Penyewa dan Registrasi.
2. Saat kendaraan berstatus tidak tersedia, sistem menampilkan pesan bahwa kendaraan tidak dapat ditambahkan ke keranjang.
3. Saat sudah login sebagai penyewa dan kendaraan tersedia, tombol Tambah ke Keranjang ditampilkan.

**Kesimpulan:**

Perubahan formulir pada halaman detail kendaraan membuat proses pengiriman data kendaraan ke Controller transaksi menjadi lebih terarah. Tombol penambahan kendaraan juga menyesuaikan status login penyewa dan ketersediaan kendaraan.

**Git Commit:**

```bash
git add .
git commit -m "Mengintegrasikan tombol keranjang pada halaman detail kendaraan"
git push
```
