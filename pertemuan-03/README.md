# pertemuan-03
### Penerapan Post-Redirect-Get (PRG)
Pada tahap ini dilakukan penelusuran dan pengujian pola
Post-Redirect-Get (PRG) pada proses autentikasi.
Penerapan PRG:
- Login berhasil menggunakan POST untuk proses autentikasi,
kemudian redirect ke /admin dan dilanjutkan dengan GET.
- Logout menggunakan POST untuk mengakhiri session,
kemudian redirect ke /auth/login dan dilanjutkan dengan GET.
Login gagal tidak menggunakan redirect karena Controller
mengembalikan View login beserta pesan kesalahan pada
request tersebut.
Pengujian aktual dilakukan terhadap:
| No. | Skenario Pengujian | Hasil Aktual | Status |
| --: | ----------------------------------- | ---------------- | ----------------------- |
| 1 | Login dengan kredensial valid | `[Login berhasil, kemudian diarahkan ke halaman /admin]` | `[Sesuai]` |
| 2 | Login dengan kredensial tidak valid | `[Login ditolak dan halaman login menampilkan pesan “Username atau password tidak sesuai.”]` | `[Sesuai]` |
| 3 | Logout melalui halaman administrasi | `[Logout berhasil, session dihapus, kemudian diarahkan ke /auth/login.]` | `[Sesuai]` |
| 4 | Akses halaman admin setelah logout | `[Pengguna tidak dapat mengakses /admin dan diarahkan kembali ke halaman /auth/login.]` | `[Sesuai]` |
Catat hasil berdasarkan eksekusi yang benar-benar dilakukan. Jika ditemukan masalah, dokumentasikan
perbaikan yang dilakukan dan ulangi pengujian yang terdampak.
### Perbaikan
| Masalah yang Ditemukan | Perbaikan yang Dilakukan | Hasil Setelah Perbaikan |
| URL aplikasi masih mengarah ke nama folder dpwl-2522500042, sedangkan nama folder project menggunakan dpwl_2522500042. | Memperbaiki konfigurasi base_url pada config.php menjadi http://localhost/dpwl_2522500042/. | URL aplikasi sudah sesuai dengan nama folder project dan proses login dapat dilanjutkan ke halaman /admin. |
| `[jika ada]` | `[perbaikan aktual]` | `[hasil aktual]` |
Jika tidak ditemukan masalah, tuliskan:
> Tidak ditemukan masalah pada saat pengujian M.3.