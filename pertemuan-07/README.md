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

### C.2. Mengubah Tombol Tambah ke Keranjang pada Halaman Katalog

Pada tahap ini, saya melakukan perubahan pada file `application/views/katalog/index.php`, khususnya pada bagian tombol **Tambah ke Keranjang** di dalam perulangan `foreach ($daftarMobil as $mobil)`. Perubahan ini bertujuan agar tombol penambahan kendaraan dapat menyesuaikan status login penyewa dan ketersediaan kendaraan.

Kondisi tombol yang diterapkan adalah sebagai berikut:

1. **Penyewa sudah login dan kendaraan tersedia:** Tombol Tambah ke Keranjang aktif dan dapat digunakan untuk mengirim data kendaraan ke route `transaksi/tambah` menggunakan metode POST.
2. **Penyewa belum login:** Tombol Tambah ke Keranjang ditampilkan dalam keadaan nonaktif.
3. **Kendaraan tidak tersedia:** Tombol diganti menjadi Tidak Dapat Disewa dan dalam keadaan nonaktif.

Formulir juga mengirimkan nomor polisi kendaraan melalui input tersembunyi (`no_plat`). Selain itu, nilai `return_to` diisi dengan `katalog` agar Controller mengetahui bahwa permintaan berasal dari halaman katalog.

**Hasil Pengujian:**

Pengujian dilakukan melalui halaman katalog kendaraan pada aplikasi localhost dengan beberapa kondisi berikut:

1. Saat belum login sebagai penyewa, tombol Tambah ke Keranjang untuk kendaraan yang tersedia tampil dalam keadaan nonaktif.
2. Setelah login sebagai penyewa, tombol Tambah ke Keranjang untuk kendaraan yang tersedia tampil aktif.
3. Kendaraan yang berstatus tidak tersedia tetap tidak dapat disewa dan tombol penambahannya dalam keadaan nonaktif.

**Kesimpulan:**

Perubahan pada halaman katalog berhasil menyesuaikan tampilan tombol berdasarkan status login penyewa dan ketersediaan kendaraan. Pada tahap ini, pengujian hanya berfokus pada tampilan dan kondisi tombol. Proses pengiriman formulir dan penyimpanan transaksi ke keranjang akan diuji setelah Controller dan Model terintegrasi.

### D.1. Mengubah `application/views/katalog/navbar.php`

Pada tahap ini, saya melakukan perubahan pada file `application/views/katalog/navbar.php` dengan menambahkan beberapa kode PHP untuk mendukung fitur keranjang penyewa dan menampilkan pesan pemberitahuan pada halaman katalog.

Kode yang ditambahkan memiliki beberapa fungsi, yaitu:

1. **Menghitung jumlah mobil di keranjang:** Menambahkan variabel `$jumlahKeranjang` untuk menampung jumlah mobil yang ada di keranjang penyewa. Jika jumlahnya belum tersedia, maka nilai awal yang digunakan adalah `0`.
2. **Mengambil pesan pemberitahuan transaksi:** Menambahkan variabel `$flashKatalog` untuk mengambil pesan dari session `flash_transaksi` yang akan digunakan pada halaman katalog.
3. **Menghapus pesan dari session:** Menggunakan `unset()` agar pesan pemberitahuan tidak terus muncul ketika halaman dibuka kembali.

Perubahan kode dilakukan pada bagian atas file `navbar.php`, sebelum penutup blok PHP (`?>`), tanpa menghapus kode yang sudah ada sebelumnya.

**Hasil Pengujian:**

1. File `application/views/katalog/navbar.php` berhasil diperbarui dengan penambahan kode P7.
2. Variabel `$jumlahKeranjang` sudah disiapkan dengan nilai awal `0` apabila jumlah keranjang belum tersedia.
3. Variabel `$flashKatalog` sudah disiapkan untuk mengambil pesan pemberitahuan dari session `flash_transaksi`.
4. Pesan pemberitahuan dihapus dari session setelah diambil agar tidak ditampilkan berulang kali.

**Kesimpulan:**

Penambahan kode pada tahap D.1 berhasil mempersiapkan navbar untuk mendukung tampilan jumlah mobil di keranjang penyewa dan pesan pemberitahuan transaksi pada halaman katalog. Untuk menampilkan jumlah keranjang yang sebenarnya, variabel `$jumlahKeranjang` masih perlu mendapatkan data dari Controller.