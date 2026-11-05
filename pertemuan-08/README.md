# pertemuan-08
A. Persiapan Folder Proyek untuk GitHub

Pada tahap awal persiapan UTS Pertemuan 8, saya memindahkan folder proyek dpwl-nim ke dalam folder baru yang bernama dpwl-nim-nama. Pemindahan ini dilakukan untuk menyesuaikan lokasi dan penamaan folder proyek yang akan digunakan dalam proses pengelolaan serta pengumpulan tugas melalui GitHub.

### 1. Penambahan Menu Manajemen Penyewa

Pada tahap ini, saya menambahkan menu **Manajemen Penyewa** pada bagian navigasi Admin. Penambahan menu ini bertujuan agar Admin dapat mengakses fitur pengelolaan data penyewa dengan lebih mudah.

Menu Manajemen Penyewa ditambahkan pada bagian sidebar AdminLTE, sejajar dengan menu Dashboard, Manajemen Admin, dan Manajemen Kendaraan. Saya juga menambahkan ikon pengguna agar menu lebih mudah dikenali.

Selain itu, saya menambahkan route `admin/penyewa` pada file `application/config/routes.php` yang diarahkan ke `Penyewa_controller`. Route ini nantinya digunakan untuk mengakses halaman Manajemen Penyewa

Setelah penambahan kode selesai, saya melakukan pemeriksaan pada halaman Admin untuk memastikan menu Manajemen Penyewa sudah muncul pada navigasi dan memiliki tautan menuju halaman yang sesuai.

**Hasil:** Menu Manajemen Penyewa berhasil ditambahkan pada navigasi Admin dan siap digunakan untuk melanjutkan pengembangan fitur pengelolaan data penyewa.

### 2. Membuat Form dan Tampilan Data Penyewa

Pada tahap ini, saya membuat halaman **Manajemen Penyewa** pada bagian Admin. Halaman ini dibuat dengan menyesuaikan tampilan halaman Manajemen Kendaraan yang sudah ada sebelumnya, sehingga tampilan dan tata letaknya tetap konsisten dengan aplikasi.

Halaman Manajemen Penyewa terdiri dari tabel untuk menampilkan data penyewa dan form yang digunakan untuk menambahkan maupun mengubah data penyewa.

**Tabel data penyewa** digunakan untuk menampilkan informasi penyewa yang tersimpan di database `t_penyewa`. Informasi yang ditampilkan meliputi username, NIK, nama lengkap, nomor HP, alamat lengkap, foto KTP, dan foto SIM A. Data password tidak ditampilkan secara langsung pada tabel karena merupakan informasi rahasia dan harus tetap terlindungi.

**Form tambah dan ubah penyewa** dibuat dengan menyediakan kolom input sesuai dengan struktur tabel `t_penyewa`, yaitu:
- Username
- Password
- NIK
- Nama lengkap
- Nomor HP
- Alamat lengkap
- Foto KTP
- Foto SIM A

Pada form ubah data, username dibuat tidak dapat diedit karena digunakan sebagai primary key atau identitas utama penyewa. Sementara itu, kolom password dapat dikosongkan apabila tidak ingin mengganti password yang sudah tersimpan.

Selain itu, form juga menyediakan input untuk mengunggah foto KTP dan SIM A sebagai dokumen identitas penyewa.

**Pengujian:**

Setelah halaman dan form selesai dibuat, saya melakukan pengujian untuk memastikan bahwa:
1. Halaman Manajemen Penyewa dapat dibuka melalui menu Admin.
2. Tabel berhasil menampilkan data penyewa dari database.
3. Form tambah penyewa dapat ditampilkan dengan lengkap.
4. Form ubah penyewa dapat menampilkan data sesuai dengan penyewa yang dipilih.
5. Seluruh kolom input yang dibutuhkan tersedia pada form.
6. Tampilan halaman Manajemen Penyewa sudah sesuai dengan tampilan halaman Manajemen Kendaraan.
7. Fitur yang sudah dibuat dapat berjalan sesuai dengan fungsinya.

**Hasil:** Seluruh pengujian pada tahap ini berhasil dilakukan. Halaman Manajemen Penyewa, tabel data, serta form tambah dan ubah penyewa berhasil ditampilkan dan berjalan sesuai dengan kebutuhan soal nomor 2.