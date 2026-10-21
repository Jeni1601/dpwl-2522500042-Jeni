# pertemuan-05
### Tahap A.5 – Dokumentasi dan Git

Pada tahap ini, saya memperbarui file README.md untuk mencatat perubahan yang dilakukan pada menu Manajemen Kendaraan. File yang diubah adalah `application/views/templates/sidebar.php` dan `application/config/routes.php`.

Pengujian dilakukan dengan menjalankan aplikasi dan mengeklik menu Manajemen Kendaraan. Hasil adalah URL berubah menjadi `admin/mobil`. Halaman kendaraan belum dapat ditampilkan karena Controller belum dibuat.

Perubahan selanjutnya dicatat menggunakan Git dan dikirim ke GitHub.

### B.3 Memperbarui README.md dan Mencatat Perubahan Git

Pada tahap ini, file `pertemuan-05/README.md` diperbarui untuk mencatat penambahan tiga route, yaitu `admin/mobil/tambah` untuk menambahkan data kendaraan, `admin/mobil/ubah/(:any)` untuk mengubah data kendaraan berdasarkan parameter nomor plat, dan `admin/mobil/hapus/(:any)` untuk menghapus data kendaraan berdasarkan parameter yang diberikan.

Berkas yang terdampak adalah `application/config/routes.php`, karena file tersebut digunakan untuk mengatur alamat URL dan menghubungkannya dengan method pada `Mobil_controller`. Setelah route ditambahkan, dilakukan pemeriksaan konfigurasi untuk memastikan penulisan route sudah sesuai dan tidak terjadi duplikasi. Hasil pemeriksaan kemudian dicatat dalam README sesuai kondisi yang benar-benar ditemukan.

### C.6 Memperbarui README.md dan Mencatat Perubahan Git

Pada tahap ini, `README.md` diperbarui untuk mencatat implementasi fitur READ data kendaraan. Berkas yang terdampak adalah `Mobil_model.php` untuk mengambil data, `Mobil_controller.php` untuk memproses data, dan `mobil_view.php` untuk menampilkan daftar kendaraan.

# Hasil Pengujian Aktual

1. **Pengujian halaman Manajemen Kendaraan:** Berhasil. Halaman `index.php/admin/mobil` dapat dibuka dan menampilkan halaman Manajemen Kendaraan.
2. **Pengujian READ data kendaraan:** Berhasil. Data kendaraan dari database ditampilkan dalam tabel, meliputi nomor plat, nama mobil, jumlah kursi, bagasi, jenis mobil, transmisi, tahun, harga per hari, status, dan foto depan.
3. **Pengujian tampilan data:** Berhasil. Tabel menampilkan beberapa data kendaraan, dilengkapi fitur pencarian, pilihan jumlah data yang ditampilkan, serta tombol Ubah dan Hapus.
4. **Pengujian foto kendaraan:** Pada data yang terlihat di screenshot, kolom foto depan menampilkan keterangan “Belum ada foto” karena foto belum tersedia.
5. **Pengujian autentikasi admin:** Belum diuji berdasarkan screenshot ini.

## D.5. Memperbarui README.md dan Mencatat Perubahan Git

Pada tahap ini, dilakukan pembaruan dokumentasi setelah fitur tambah kendaraan (INSERT) berhasil diimplementasikan. Fitur ini digunakan untuk menambahkan data kendaraan baru ke tabel "t_mobil" melalui pola MVC (Model, View, Controller).

Perubahan yang dilakukan meliputi:

1. Model ("Mobil_model.php")
   Menambahkan method "create()" untuk menyimpan data kendaraan ke database menggunakan prepared statement.

2. Controller ("Mobil_controller.php")
   Menambahkan proses penambahan kendaraan, validasi input, dan pengelolaan unggahan foto kendaraan.

3. View ("mobil_view.php")
   Membuat formulir tambah kendaraan yang berisi data kendaraan, seperti nomor plat, nama mobil, jumlah kursi, jumlah bagasi, jenis mobil, transmisi, tahun pembuatan, foto kendaraan, harga sewa, catatan, dan status kendaraan.

4. Pengujian fitur
   Melakukan pengujian untuk memastikan data kendaraan dapat ditambahkan, validasi berjalan dengan baik, dan data yang tersimpan ditampilkan pada halaman manajemen kendaraan. Fitur READ juga harus tetap berfungsi.

5. Pencatatan perubahan Git
   Setelah hasil pengembangan disalin ke folder "pertemuan-05", perubahan diperiksa menggunakan Git, kemudian dilakukan commit dan push ke GitHub sebagai dokumentasi perkembangan proyek.

Kesimpulan: Tahap D.5 bertujuan mendokumentasikan implementasi fitur tambah kendaraan beserta hasil pengujiannya dan menyimpan perkembangan proyek menggunakan Git dan GitHub.

E.6. Pembaruan README.md dan Pencatatan Perubahan Git

Pada tahap ini, dilakukan dokumentasi hasil implementasi dan pengujian fitur UPDATE data kendaraan.

1. Implementasi Fitur UPDATE

Fitur UPDATE digunakan untuk mengubah data kendaraan yang sudah tersimpan di database. Admin dapat membuka formulir edit, mengubah informasi kendaraan, kemudian menyimpan perubahan tersebut.

2. Hasil Pengujian

Pengujian fitur UPDATE berhasil dilakukan. Data kendaraan dapat diubah melalui formulir edit dan disimpan ke dalam database. Setelah proses penyimpanan berhasil, data terbaru ditampilkan pada halaman daftar kendaraan sesuai dengan perubahan yang dilakukan.

3. Dokumentasi Perubahan

File "README.md" diperbarui untuk mencatat implementasi fitur UPDATE dan hasil pengujiannya. Berkas program yang mengalami perubahan juga disalin ke folder "pertemuan-05/" sesuai struktur proyek.

4. Pencatatan Perubahan Menggunakan Git

Setelah kode program dan dokumentasi diperbarui, perubahan dicatat menggunakan Git dengan perintah berikut:

git add .
git commit -m "Implementasi fitur UPDATE data kendaraan dan pembaruan README"
git push

Kesimpulan

Fitur UPDATE data kendaraan telah berhasil diimplementasikan dan diuji. Data kendaraan dapat diperbarui dan disimpan ke dalam database. Dokumentasi serta perubahan kode dicatat dalam repositori Git agar tersimpan dengan baik.

F.4. Memperbarui README.md dan Mencatat Perubahan Git

Pada tahap ini, dilakukan pembaruan dokumentasi setelah implementasi dan pengujian fitur DELETE data kendaraan selesai.

1. Implementasi Fitur DELETE

Fitur DELETE digunakan untuk menghapus data kendaraan yang sudah tersimpan di database. Proses penghapusan dilakukan melalui menu atau tombol hapus pada halaman daftar kendaraan.

2. Hasil Pengujian

Pengujian fitur DELETE dilakukan untuk memastikan data kendaraan dapat dihapus dari database. Setelah proses penghapusan berhasil, data kendaraan yang dipilih tidak lagi ditampilkan pada halaman daftar kendaraan.

3. Pembaruan Dokumentasi

File "README.md" diperbarui untuk menjelaskan implementasi fitur DELETE, perubahan berkas program, dan hasil pengujian yang telah dilakukan. Berkas program yang baru atau mengalami perubahan disalin ke folder "pertemuan-05/".

4. Pencatatan Perubahan Menggunakan Git

Setelah kode program dan dokumentasi diperbarui, perubahan dicatat menggunakan Git dengan perintah berikut:

git add .
git commit -m "Implementasi fitur DELETE data kendaraan dan pembaruan README"
git push

Kesimpulan

Fitur DELETE dikembangkan untuk melengkapi pengelolaan data kendaraan pada aplikasi penyewaan kendaraan berbasis PHP dengan pendekatan MVC. Dokumentasi diperbarui dan perubahan kode disimpan ke repositori Git agar perkembangan proyek tercatat dengan baik.