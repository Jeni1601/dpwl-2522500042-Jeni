# pertemuan-09
### P9 — Tahap 4: Membuat Model Pembayaran

Pada tahap ini dilakukan pembuatan file `Pembayaran_model.php` pada folder `application/models/`. Model ini digunakan untuk mengelola data pembayaran yang tersimpan pada tabel `t_bayar` dan berhubungan dengan tabel `t_sewa` serta `t_penyewa`.

Fungsi yang dibuat pada model pembayaran meliputi pengambilan data pembayaran berdasarkan penyewa yang sedang login, pengambilan detail pembayaran penyewa, penyimpanan bukti pembayaran, pengambilan seluruh data pembayaran untuk Admin, pengambilan detail pembayaran untuk proses verifikasi, dan pembaruan status pembayaran menjadi valid atau invalid.

Pengambilan data pembayaran dilakukan menggunakan prepared statement dan relasi antar tabel. Data pembayaran penyewa difilter berdasarkan username agar penyewa hanya dapat mengakses pembayaran miliknya sendiri. Selain itu, bukti pembayaran dapat diunggah kembali apabila status pembayaran masih pending atau sebelumnya dinyatakan invalid.

Pada tahap ini juga dilakukan pemeriksaan syntax PHP menggunakan perintah `php -l` untuk memastikan file model tidak memiliki kesalahan syntax.

**Hasil:** File `Pembayaran_model.php` berhasil dibuat dan syntax PHP berhasil diperiksa tanpa kesalahan. Pengujian fungsi secara langsung akan dilanjutkan setelah controller dan halaman pembayaran terintegrasi.