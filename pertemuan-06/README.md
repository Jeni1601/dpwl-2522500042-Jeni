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