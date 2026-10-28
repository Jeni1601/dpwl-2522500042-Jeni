# pertemuan-06
## A.6. Menguji Tampilan, Pemuatan Aset, dan Navigasi

Pada tahap A6, saya melakukan pemeriksaan terhadap struktur folder aplikasi dan ketersediaan aset template Zay Shop yang akan digunakan pada aplikasi rental kendaraan. Pemeriksaan ini bertujuan untuk memastikan aset tersedia dan mengetahui jalur yang perlu disesuaikan saat proses integrasi dengan aplikasi MVC.

### Hasil Pemeriksaan

| No. | Komponen yang diperiksa | Hasil pemeriksaan |
|---|---|---|
| 1 | Struktur View aplikasi | Folder `application/views` ditemukan. |
| 2 | Folder View yang tersedia | Terdapat folder `admin`, `auth`, `home`, dan `templates`. |
| 3 | Komponen template | Folder `application/views/templates` memiliki file `header.php`, `footer.php`, dan `sidebar.php`. |
| 4 | Folder CSS | Folder `assets/zay/css` tersedia dan berisi file CSS. |
| 5 | Folder JavaScript | Folder `assets/zay/js` tersedia dan berisi file JavaScript. |
| 6 | Folder gambar | Folder `assets/zay/img` tersedia dan berisi file gambar. |
| 7 | Folder webfonts | Folder `assets/zay/webfont` tersedia. |
| 8 | Kesesuaian jalur aset | Jalur aset pada HTML template perlu dicocokkan dengan lokasi aset di aplikasi MVC. |
| 9 | Tampilan dan navigasi | Belum dinyatakan berhasil karena pengujian melalui aplikasi MVC belum dikonfirmasi. |

### Penyesuaian yang Diperlukan

Berdasarkan hasil pemeriksaan, folder CSS, JavaScript, dan gambar telah ditemukan beserta file di dalamnya. Folder `webfont` juga tersedia, tetapi keberadaan dan kesesuaian file font yang dibutuhkan masih perlu diperiksa.

Jalur CSS, JavaScript, gambar, dan webfonts pada template Zay Shop perlu dicocokkan dengan lokasi aset di aplikasi MVC. Komponen `header.php` dan `footer.php` yang sudah tersedia di folder `application/views/templates` juga perlu diperiksa sebelum integrasi agar tidak terjadi duplikasi kode.

### Kesimpulan

Hasil pemeriksaan menunjukkan bahwa sebagian besar struktur folder dan aset utama Zay Shop sudah tersedia di dalam proyek. Tahap selanjutnya adalah memeriksa kesesuaian jalur aset dan memastikan file yang dibutuhkan oleh template tersedia. Keberhasilan tampilan, pemuatan aset, dan navigasi harus dibuktikan melalui pengujian setelah integrasi pada aplikasi MVC selesai.


## B.4. Hasil Pengujian Integrasi Model, Controller, View, dan Navigasi Katalog

Pengujian dilakukan dengan membuka halaman katalog kendaraan melalui browser menggunakan URL `http://localhost/dpwl-2522500042-Jeni/pertemuan-06/index.php/katalog`.

### Hasil Pengujian

| No. | Skenario Pengujian | Hasil yang Diharapkan | Hasil Aktual |
|---|---|---|---|
| 1 | Membuka halaman katalog melalui route `/katalog`. | Halaman katalog kendaraan berhasil ditampilkan. | Berhasil, halaman katalog kendaraan muncul di browser. |
| 2 | Memeriksa integrasi Controller dan View. | Controller memanggil View untuk menampilkan halaman katalog. | Halaman katalog berhasil ditampilkan. |
| 3 | Memeriksa pengambilan data kendaraan dari Model. | Data kendaraan ditampilkan sesuai data yang tersedia di database. | Perlu diperiksa dengan memastikan data kendaraan yang muncul sesuai isi database. |
| 4 | Memeriksa navigasi katalog. | Tautan navigasi dapat digunakan sesuai fungsinya. | Perlu diuji dengan mencoba tautan navigasi yang tersedia. |

### Kesimpulan

Berdasarkan pengujian awal, halaman katalog kendaraan berhasil diakses melalui route `/katalog` dan ditampilkan di browser. Hal ini menunjukkan bahwa halaman katalog sudah dapat dibuka. Pengujian pengambilan data dari Model dan fungsi navigasi perlu dipastikan kembali agar integrasi Model, Controller, View, dan navigasi dapat dinyatakan berjalan dengan baik.


## C.4. Hasil Pengujian Navigasi Katalog ke Detail dan Penanganan Galat

Pengujian dilakukan untuk memastikan navigasi dari halaman katalog ke halaman detail kendaraan berjalan dengan baik serta aplikasi dapat menangani kondisi ketika kendaraan tidak ditemukan.

### Hasil Pengujian

| No. | Skenario Pengujian | Hasil yang Diharapkan | Hasil Aktual |
|---|---|---|---|
| 1 | Membuka halaman katalog melalui URL `/index.php/katalog`. | Halaman katalog kendaraan ditampilkan. | Berhasil, halaman katalog kendaraan muncul di browser. |
| 2 | Mengeklik foto atau nama kendaraan pada halaman katalog. | Pengguna diarahkan ke halaman detail kendaraan yang dipilih. | Berhasil, halaman detail kendaraan dapat dibuka. |
| 3 | Memeriksa informasi kendaraan pada halaman detail. | Informasi kendaraan ditampilkan sesuai kendaraan yang dipilih. | Berhasil, informasi detail kendaraan ditampilkan. |
| 4 | Membuka URL detail menggunakan nomor polisi kendaraan yang tidak terdaftar. | Aplikasi menampilkan pesan `Kendaraan tidak ditemukan.` dengan status HTTP 404. | Berhasil, aplikasi menampilkan penanganan galat untuk kendaraan yang tidak ditemukan. |

### Kesimpulan

Berdasarkan hasil pengujian, navigasi dari halaman katalog ke halaman detail kendaraan berjalan dengan baik. Informasi detail kendaraan dapat ditampilkan, dan aplikasi juga dapat menangani permintaan detail kendaraan yang tidak ditemukan. Dengan demikian, pengujian pada tahap C.4 berhasil dilakukan sesuai dengan skenario pengujian.


## D.5. Hasil Pengujian Registrasi Penyewa

Pengujian dilakukan untuk memastikan fitur registrasi penyewa berjalan dengan baik. Pengujian meliputi registrasi menggunakan data valid, input tidak valid, dan pendaftaran menggunakan username yang sudah terdaftar.

### Hasil Pengujian

| No. | Skenario Pengujian | Hasil yang Diharapkan | Hasil Aktual |
|---|---|---|---|
| 1 | Melakukan registrasi menggunakan data yang valid dan username yang belum terdaftar. | Akun penyewa berhasil dibuat dan sistem menampilkan pesan keberhasilan. | Berhasil, akun penyewa berhasil didaftarkan menggunakan data yang valid. |
| 2 | Melakukan registrasi dengan input yang tidak valid. | Sistem menolak data dan menampilkan pesan kesalahan. | Berhasil, sistem menolak input yang tidak valid dan menampilkan pesan kesalahan. |
| 3 | Melakukan registrasi menggunakan username yang sudah terdaftar. | Sistem menolak pendaftaran dan menampilkan pesan bahwa username sudah digunakan. | Berhasil, sistem menolak pendaftaran dengan username yang sudah terdaftar. |

### Kesimpulan

Berdasarkan hasil pengujian, fitur registrasi penyewa berjalan sesuai dengan yang diharapkan. Sistem dapat menyimpan akun baru menggunakan data yang valid, menolak input yang tidak valid, dan mencegah penggunaan username yang sudah terdaftar. Dengan demikian, pengujian pada tahap D.5 berhasil dilakukan.


## E.4. Hasil Pengujian Login, Sesi, Logout, dan Pembatasan Akses Penyewa

Pengujian dilakukan untuk memastikan fitur login dan logout penyewa berjalan dengan baik. Pengujian meliputi login menggunakan data yang benar, login menggunakan data yang salah, pengelolaan sesi, proses logout, dan pembatasan akses setelah logout.

### Hasil Pengujian

| No. | Skenario Pengujian | Hasil yang Diharapkan | Hasil Aktual |
|---|---|---|---|
| 1 | Login menggunakan username dan password yang benar. | Sistem menerima login dan membuat sesi penyewa. | Berhasil, penyewa dapat login menggunakan akun yang sudah terdaftar. |
| 2 | Login menggunakan username atau password yang salah. | Sistem menolak login dan menampilkan pesan kesalahan. | Berhasil, sistem menolak login dan menampilkan pesan kesalahan. |
| 3 | Mengakses halaman yang memerlukan sesi setelah login. | Sistem mengenali sesi penyewa dan mengizinkan akses ke halaman yang sesuai. | Berhasil, penyewa yang sudah login dapat mengakses halaman yang memerlukan sesi. |
| 4 | Melakukan logout melalui menu logout penyewa. | Sistem mengakhiri sesi penyewa. | Berhasil, penyewa dapat logout dan sesi login berakhir. |
| 5 | Mengakses kembali halaman yang memerlukan login setelah logout. | Sistem menolak akses tanpa sesi login. | Berhasil, sistem membatasi akses setelah penyewa logout. |

### Kesimpulan

Berdasarkan hasil pengujian, fitur login, pengelolaan sesi, logout, dan pembatasan akses penyewa berjalan sesuai dengan yang diharapkan. Sistem dapat menerima data login yang benar, menolak data login yang salah, mengelola sesi penyewa, serta membatasi akses ke halaman yang memerlukan login setelah penyewa logout. Dengan demikian, pengujian pada tahap E.4 berhasil dilakukan.


## F.5. Hasil Pengujian Pembaruan Profil dan Penanganan Input Tidak Valid

Pengujian dilakukan pada halaman profil penyewa melalui menu ikon profil. Tujuan pengujian ini adalah memastikan data profil penyewa dapat diperbarui dan sistem dapat menangani input yang tidak sesuai dengan ketentuan.

### Hasil Pengujian

| No. | Skenario Pengujian | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|
| 1 | Membuka halaman profil setelah login sebagai penyewa. | Halaman profil menampilkan data penyewa yang sedang login. | Berhasil apabila data profil penyewa tampil sesuai akun yang digunakan. |
| 2 | Mengubah data profil dengan input yang valid, seperti NIK 16 digit, nama lengkap, nomor HP, dan alamat. | Sistem menyimpan perubahan dan menampilkan data profil terbaru. | Berhasil apabila perubahan tersimpan dan data terbaru ditampilkan kembali. |
| 3 | Mengisi NIK kurang atau lebih dari 16 digit atau menggunakan karakter selain angka. | Sistem menolak input NIK yang tidak sesuai ketentuan. | Berhasil apabila input NIK yang tidak valid ditolak. |
| 4 | Mengisi nama lengkap menggunakan angka. | Sistem menolak nama yang tidak sesuai format. | Berhasil apabila nama yang mengandung angka ditolak. |
| 5 | Mengosongkan salah satu kolom wajib, seperti nama lengkap, nomor HP, atau alamat. | Sistem meminta pengguna melengkapi kolom wajib sebelum menyimpan perubahan. | Berhasil apabila data tidak valid tidak dapat disimpan. |

### Kesimpulan

Berdasarkan pengujian yang dilakukan, fitur profil penyewa digunakan untuk menampilkan dan memperbarui data penyewa. Validasi input diperlukan agar data yang disimpan sesuai dengan ketentuan. Pengujian dinyatakan berhasil apabila perubahan data valid dapat disimpan dan input tidak valid ditolak oleh sistem.


### G.5. Pengujian Penghilangan `index.php` dari URL Aplikasi

**Perubahan yang dilakukan:**

- Mengubah `default_controller` pada `application/config/routes.php` menjadi `Katalog_controller`.
- Menyesuaikan konfigurasi URL agar aplikasi dapat diakses tanpa menuliskan `index.php`.
- Menguji halaman utama dan navigasi aplikasi setelah perubahan konfigurasi.

**Hasil pengujian aktual:**

| No. | Skenario Pengujian | Hasil Aktual | Status |
|---|---|---|---|
| 1 | Mengakses halaman utama melalui `http://localhost/dpwl_2522500042`. | Halaman utama katalog berhasil ditampilkan tanpa menuliskan `index.php` pada URL. | Berhasil |
| 2 | Mengakses halaman katalog melalui navigasi aplikasi. | Halaman katalog dapat dibuka dengan baik. | Berhasil |
| 3 | Mengklik navigasi yang tersedia pada aplikasi. | Navigasi dapat digunakan dan mengarah ke halaman yang sesuai. | Berhasil |
| 4 | Memeriksa URL pada address bar browser. | URL aplikasi dapat diakses tanpa menampilkan `index.php`. | Berhasil |
| 5 | Memastikan fitur aplikasi yang telah dibuat tetap berjalan setelah perubahan. | Fitur yang diuji dapat berjalan tanpa galat. | Berhasil |

**Kesimpulan:**

Berdasarkan hasil pengujian, tahap G.5 berhasil dilakukan. Pengaturan `default_controller` telah diarahkan ke `Katalog_controller`, sehingga halaman katalog menjadi halaman utama aplikasi. URL aplikasi dapat diakses tanpa menuliskan `index.php`, navigasi berjalan dengan baik, dan fitur yang diuji tetap dapat digunakan tanpa galat.
