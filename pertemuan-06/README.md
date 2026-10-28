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