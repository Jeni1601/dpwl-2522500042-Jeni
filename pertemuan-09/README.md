# pertemuan-09
### P9 — Tahap 4: Membuat Model Pembayaran

Pada tahap ini dilakukan pembuatan file `Pembayaran_model.php` pada folder `application/models/`. Model ini digunakan untuk mengelola data pembayaran yang tersimpan pada tabel `t_bayar` dan berhubungan dengan tabel `t_sewa` serta `t_penyewa`.

Fungsi yang dibuat pada model pembayaran meliputi pengambilan data pembayaran berdasarkan penyewa yang sedang login, pengambilan detail pembayaran penyewa, penyimpanan bukti pembayaran, pengambilan seluruh data pembayaran untuk Admin, pengambilan detail pembayaran untuk proses verifikasi, dan pembaruan status pembayaran menjadi valid atau invalid.

Pengambilan data pembayaran dilakukan menggunakan prepared statement dan relasi antar tabel. Data pembayaran penyewa difilter berdasarkan username agar penyewa hanya dapat mengakses pembayaran miliknya sendiri. Selain itu, bukti pembayaran dapat diunggah kembali apabila status pembayaran masih pending atau sebelumnya dinyatakan invalid.

Pada tahap ini juga dilakukan pemeriksaan syntax PHP menggunakan perintah `php -l` untuk memastikan file model tidak memiliki kesalahan syntax.

**Hasil:** File `Pembayaran_model.php` berhasil dibuat dan syntax PHP berhasil diperiksa tanpa kesalahan. Pengujian fungsi secara langsung akan dilanjutkan setelah controller dan halaman pembayaran terintegrasi.

### P9 — Tahap 5: Membuat Controller Pembayaran

Pada tahap ini dilakukan pembuatan file `Pembayaran_controller.php` pada folder `application/controllers/`. Controller ini berfungsi menghubungkan model pembayaran dengan halaman yang akan ditampilkan kepada penyewa.

Controller memiliki method `index()` untuk mengambil dan menampilkan daftar pembayaran penyewa serta method `detail()` untuk mengambil detail pembayaran berdasarkan kode pembayaran. Pengambilan data dilakukan dengan memanggil fungsi yang tersedia pada `Pembayaran_model.php`.

Selain itu, dibuat method `wajibLoginPenyewa()` untuk memeriksa session login penyewa. Jika penyewa belum login, sistem akan mengarahkannya ke halaman login penyewa. Pada pengambilan detail pembayaran, kode pembayaran dan username penyewa digunakan untuk memastikan data yang diakses merupakan milik penyewa yang sedang login.

Pada tahap ini juga dilakukan pemeriksaan syntax PHP menggunakan perintah `php -l` untuk memastikan controller tidak memiliki kesalahan syntax.

**Hasil:** File `Pembayaran_controller.php` berhasil dibuat untuk mengatur pengambilan daftar dan detail pembayaran penyewa. Pengujian halaman di browser akan dilanjutkan setelah pembuatan view dan integrasi routes.