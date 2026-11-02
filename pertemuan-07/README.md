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

### D.2.2 Memperbarui Katalog_controller.php

Pada tahap ini, dilakukan perubahan pada file `application/controllers/Katalog_controller.php` dengan menambahkan integrasi `Transaksi_model.php`. Tujuannya adalah agar sistem dapat menghitung jumlah kendaraan yang sudah dimasukkan ke dalam keranjang berdasarkan akun penyewa yang sedang login.

Perubahan dilakukan dengan menambahkan pemanggilan model transaksi, membuat properti `$transaksiModel`, serta melakukan inisialisasi objek `Transaksi_model` pada bagian constructor.

Selanjutnya, method `index()` dan `detail()` diperbarui agar dapat mengirimkan data `jumlahKeranjang` ke halaman View. Jika penyewa belum login, jumlah keranjang akan bernilai 0. Jika penyewa sudah login, sistem akan menghitung jumlah kendaraan berdasarkan akun penyewa tersebut.

**Hasil Pengujian:**

1. Membuka halaman katalog kendaraan melalui localhost. Halaman katalog berhasil ditampilkan.
2. Membuka halaman detail kendaraan. Informasi kendaraan berhasil ditampilkan dengan benar.
3. Mengakses halaman katalog ketika belum login sebagai penyewa. Halaman tetap dapat dibuka dan jumlah keranjang bernilai 0.
4. Login sebagai penyewa, kemudian membuka halaman katalog dan detail kendaraan. Jumlah keranjang ditampilkan sesuai dengan data keranjang milik akun penyewa.
5. Jika keranjang masih kosong, jumlah yang ditampilkan adalah 0.

**Kesimpulan:**

Setelah perubahan dilakukan, `Katalog_controller.php` sudah terintegrasi dengan `Transaksi_model.php`. Dengan demikian, halaman katalog dan detail kendaraan dapat menerima data jumlah keranjang sesuai dengan akun penyewa yang sedang login. Perubahan ini juga membantu agar jumlah keranjang yang ditampilkan pada navbar tidak mengambil data dari akun penyewa lain.VV

### D.2.3. Memperbarui `Penyewa_controller.php` 

Pada tahap ini, saya memperbarui method `renderProfilError()` pada file `application/controllers/Penyewa_controller.php`. Perubahan dilakukan agar jumlah kendaraan yang ada di keranjang tetap dikirim ke halaman profil penyewa meskipun terjadi kesalahan saat memproses atau memvalidasi data profil.

Saya menambahkan proses untuk mengambil username penyewa dari session `penyewa_user_plg`, kemudian menghitung jumlah kendaraan dalam keranjang menggunakan method `getJumlahMobilKeranjang()` dari `Transaksi_model`. Jika session penyewa kosong, jumlah keranjang akan diatur menjadi 0.

Selanjutnya, variabel `jumlahKeranjang` ditambahkan ke dalam array data pada pemanggilan View `penyewa/profil`. Dengan perubahan ini, navbar tetap dapat menampilkan jumlah kendaraan dalam keranjang meskipun halaman profil sedang menampilkan pesan kesalahan.

**Hasil Pengujian:**
- Method `renderProfilError()` mengirimkan data jumlah keranjang ke halaman profil.
- Jika penyewa memiliki kendaraan dalam keranjang, jumlahnya ditampilkan sesuai data akun penyewa.
- Jika tidak ada kendaraan dalam keranjang, jumlah yang ditampilkan adalah 0.
- Pesan kesalahan pada halaman profil tetap dapat ditampilkan tanpa menghilangkan jumlah keranjang.

**Kesimpulan:**

Perubahan pada nomor 7 membuat tampilan navbar di halaman profil tetap konsisten karena jumlah kendaraan dalam keranjang tetap dikirim, termasuk ketika terjadi kesalahan pada proses pengolahan data profil.

### E.1. Menambahkan Method `tambahKeKeranjang()`

Pada tahap ini, saya menambahkan method `tambahKeKeranjang()` pada file `application/models/Transaksi_model.php`. Method ini berfungsi untuk memproses penambahan kendaraan ke dalam keranjang penyewaan milik penyewa yang sedang login.

Sebelum menambahkan method tersebut, saya juga menambahkan beberapa helper yang diperlukan, yaitu `namaKunciKeranjang()`, `kunciKendaraan()`, `hitungHariSewa()`, dan helper untuk menormalisasi waktu pengambilan. Helper tersebut digunakan untuk mengelola kunci keranjang, memeriksa ketersediaan kendaraan, serta menghitung durasi penyewaan.

Method `tambahKeKeranjang()` bekerja dengan memeriksa identitas penyewa dan nomor kendaraan terlebih dahulu. Selanjutnya, sistem memeriksa apakah kendaraan tersedia dan mencari keranjang aktif milik penyewa. Jika keranjang belum tersedia, sistem akan membuat transaksi baru. Jika sudah ada, kendaraan akan ditambahkan ke keranjang yang sama.

Data transaksi utama disimpan pada tabel `t_sewa`, sedangkan kendaraan yang dipilih disimpan pada tabel `t_pilih` dengan menggunakan `kode_sewa` yang sama. Proses penyimpanan menggunakan transaksi database agar data tetap konsisten apabila terjadi kesalahan.

**Hasil Pengujian** 

Berdasarkan pengujian yang telah dilakukan, fitur penambahan kendaraan ke keranjang berhasil berjalan sesuai dengan yang diharapkan. Berikut hasil dari keenam pengujian:

1. **Pengujian menambahkan kendaraan ke keranjang:** Berhasil. Kendaraan yang tersedia dapat ditambahkan ke keranjang melalui halaman katalog.
2. **Pengujian penyimpanan data transaksi:** Berhasil. Data transaksi tersimpan pada tabel `t_sewa` di database.
3. **Pengujian penyimpanan detail kendaraan:** Berhasil. Kendaraan yang dipilih tersimpan pada tabel `t_pilih` dengan `kode_sewa` yang sesuai.
4. **Pengujian menambahkan kendaraan lain:** Berhasil. Kendaraan lain dapat ditambahkan ke keranjang yang sama selama transaksi masih berstatus keranjang.
5. **Pengujian kendaraan yang sama:** Berhasil. Sistem menolak penambahan kendaraan yang sama agar tidak terjadi data duplikat dalam satu keranjang.
6. **Pengujian ketersediaan kendaraan:** Berhasil. Sistem hanya mengizinkan kendaraan dengan status tersedia untuk ditambahkan ke keranjang.

**Kesimpulan Pengujian:**

Berdasarkan keenam pengujian tersebut, fitur `tambahKeKeranjang()` berhasil diterapkan. Sistem dapat menyimpan data transaksi dan detail kendaraan ke database, menggunakan keranjang yang sama untuk beberapa kendaraan, serta mencegah penambahan kendaraan yang duplikat atau tidak tersedia.

### F.1. Membuat Halaman Isi Keranjang

Pada tahap F.1, saya membuat halaman isi keranjang pada file `application/views/transaksi/keranjang.php`. Halaman ini digunakan untuk menampilkan informasi transaksi penyewaan kendaraan yang sebelumnya sudah ditambahkan oleh penyewa melalui halaman katalog.

Informasi yang ditampilkan meliputi kode transaksi, status transaksi, tanggal mulai dan selesai sewa, waktu pengambilan kendaraan, daftar kendaraan yang dipilih, harga sewa per hari, durasi sewa, subtotal, dan total biaya sewa.

Selain menampilkan informasi transaksi, halaman ini juga menyediakan beberapa fitur, yaitu:

1. **Update Keranjang**, digunakan untuk memperbarui tanggal mulai, tanggal selesai, dan waktu pengambilan kendaraan.
2. **Daftar Kendaraan**, menampilkan kendaraan yang sudah dimasukkan ke dalam keranjang beserta nomor polisi, harga sewa, durasi, dan subtotal.
3. **Lanjut Pilih Kendaraan**, digunakan untuk kembali ke halaman katalog.
4. **Aksi Kendaraan**, menyediakan tombol untuk menghapus kendaraan dari keranjang.
5. **Lanjut Checkout**, menyediakan akses untuk melanjutkan proses pengajuan transaksi.

Pada halaman ini juga digunakan fungsi `htmlspecialchars()` untuk melakukan escape terhadap data sebelum ditampilkan ke HTML agar lebih aman. Selain itu, fungsi `number_format()` digunakan untuk menampilkan harga dalam format Rupiah.

**Hasil Pengujian:**

Pengujian dilakukan dengan membuka halaman keranjang melalui aplikasi localhost menggunakan akun penyewa. Pemeriksaan dilakukan terhadap tampilan informasi transaksi, periode sewa, waktu pengambilan, daftar kendaraan, harga sewa, durasi, subtotal, dan total biaya sewa.

**Kesimpulan:**

Pembuatan halaman isi keranjang bertujuan agar penyewa dapat melihat dan memeriksa kendaraan yang telah dipilih sebelum melanjutkan ke proses checkout. Halaman ini menjadi bagian dari proses transaksi penyewaan kendaraan pada aplikasi DPWL.

### F.2 Menambahkan Method keranjang() dan Lainnya pada Controller Transaksi 

Pengujian dilakukan menggunakan dua akun penyewa dengan kondisi keranjang yang berbeda.

**1. Login sebagai penyewa yang memiliki keranjang aktif**

- Penyewa berhasil masuk ke halaman keranjang melalui menu keranjang.
- Informasi transaksi berhasil ditampilkan, seperti kode transaksi, status keranjang, tanggal mulai, tanggal selesai, dan waktu pengambilan.
- Jumlah kendaraan pada ikon keranjang di navbar menunjukkan angka **2**, sesuai dengan jumlah kendaraan yang ada di keranjang penyewa tersebut.

**Hasil:** Berhasil. Halaman keranjang menampilkan informasi transaksi dan jumlah kendaraan sesuai dengan data penyewa yang sedang login.

**2. Login sebagai penyewa yang belum memiliki keranjang aktif**

- Penyewa berhasil masuk ke halaman katalog kendaraan.
- Sistem menampilkan pesan **"Keranjang Anda masih kosong."**
- Jumlah kendaraan pada ikon keranjang di navbar menunjukkan angka **0** karena penyewa belum memiliki keranjang aktif.

**Hasil:** Berhasil. Sistem dapat mengenali penyewa yang belum memiliki keranjang aktif dan menampilkan jumlah kendaraan 0 pada navbar.

**Kesimpulan Pengujian:**

Berdasarkan pengujian yang telah dilakukan, fitur keranjang berhasil menampilkan data sesuai dengan akun penyewa yang sedang login. Jumlah kendaraan pada navbar juga menyesuaikan dengan isi keranjang masing-masing penyewa. Dengan demikian, data keranjang antarpenyewa tidak tercampur.