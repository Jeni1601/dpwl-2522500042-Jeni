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

## Tahap 6: Membuat Halaman Daftar Pembayaran Penyewa

Pada tahap ini dilakukan pembuatan halaman daftar pembayaran penyewa pada file application/views/pembayaran/index.php. Halaman ini digunakan untuk menampilkan data pembayaran yang telah tercatat setelah penyewa melakukan checkout.

Informasi yang ditampilkan meliputi kode pembayaran, kode sewa, tanggal pembayaran, jenis pembayaran, nominal pembayaran, metode pembayaran, dan status pembayaran. Status pembayaran ditampilkan menggunakan badge untuk membedakan pembayaran yang masih menunggu verifikasi, sudah valid, atau tidak valid.

Halaman dibuat menggunakan komponen Bootstrap dan mengikuti tampilan halaman katalog serta keranjang yang sudah ada. Selain itu, digunakan htmlspecialchars() untuk mengamankan data yang ditampilkan dan fungsi format rupiah agar nominal pembayaran lebih mudah dibaca.

Disediakan juga tombol Detail untuk menuju halaman detail pembayaran. Integrasi routes dan pengujian halaman akan dilanjutkan pada tahapan berikutnya.

Hasil: Halaman daftar pembayaran penyewa berhasil dibuat dan syntax PHP berhasil diperiksa. Integrasi ke browser akan dilakukan setelah routes dan halaman detail pembayaran tersedia.

## Tahap 7: Membuat Halaman Detail dan Upload Bukti Pembayaran

Pada tahap ini dilakukan pembuatan halaman detail pembayaran penyewa pada file application/views/pembayaran/detail.php. Halaman ini digunakan untuk menampilkan informasi pembayaran secara lebih lengkap, seperti kode pembayaran, kode sewa, tanggal pembayaran, jenis pembayaran, nominal, metode pembayaran, status pembayaran, dan tanggal verifikasi.

Selain menampilkan detail pembayaran, dibuat juga fitur upload bukti pembayaran untuk penyewa yang menggunakan metode transfer. File bukti pembayaran dibatasi maksimal 5 MB dengan format JPG, JPEG, PNG, atau WEBP. File disimpan pada folder uploads/pembayaran/ dengan nama file unik.

Fitur upload hanya dapat dilakukan oleh penyewa yang memiliki transaksi tersebut dan pembayaran dengan status pending atau invalid. Setelah bukti pembayaran berhasil diunggah, status pembayaran akan dikembalikan menjadi pending agar Admin dapat melakukan verifikasi ulang.

Pada controller Pembayaran_controller.php, ditambahkan fungsi uploadBukti() untuk menangani proses upload, validasi file, penyimpanan file, dan pembaruan data bukti pembayaran pada database. Fungsi detail() juga diperbarui untuk menampilkan pesan hasil upload.

Hasil: Halaman detail pembayaran dan proses upload bukti pembayaran berhasil dibuat. Pemeriksaan syntax PHP dilakukan pada file view dan controller. Pengujian melalui browser akan dilanjutkan setelah integrasi routes pada tahap berikutnya.

### Tahap 8: Membuat Halaman Daftar Pembayaran Admin

Pada tahap ini dilakukan pembuatan halaman daftar pembayaran untuk Admin pada file `application/views/admin/pembayaran/index.php`. Halaman ini digunakan untuk menampilkan seluruh data pembayaran penyewa yang telah tercatat pada sistem.

Informasi yang ditampilkan meliputi kode pembayaran, kode sewa, nama penyewa, tanggal pembayaran, jenis pembayaran, nominal, metode pembayaran, dan status pembayaran. Status pembayaran menggunakan label berwarna untuk membedakan pembayaran yang menunggu verifikasi, valid, dan tidak valid.

Halaman dibuat menggunakan template AdminLTE 2 yang telah digunakan pada halaman Admin sebelumnya. Tabel menggunakan class `js-data-table` agar mengikuti pengaturan DataTables yang sudah tersedia pada template Admin.

Disediakan tombol Detail pada setiap baris pembayaran untuk menuju halaman pemeriksaan pembayaran. Integrasi controller dan routes serta proses menerima atau menolak pembayaran akan dilanjutkan pada tahapan berikutnya.

**Hasil:** Halaman daftar pembayaran Admin berhasil dibuat dan syntax PHP telah diperiksa. Pengujian melalui browser akan dilakukan setelah integrasi controller dan routes selesai.

### Tahap 9: Membuat Proses Verifikasi Pembayaran Admin

Pada tahap ini dilakukan pembuatan proses verifikasi pembayaran oleh Admin pada controller `Pembayaran_controller.php`. Proses verifikasi digunakan untuk menentukan apakah pembayaran penyewa diterima atau ditolak.

Ditambahkan fungsi `verifikasiAdmin()` untuk menangani proses verifikasi pembayaran. Fungsi ini memastikan Admin sudah login, memeriksa metode permintaan, memvalidasi status pembayaran, dan memproses verifikasi melalui `Pembayaran_model`.

Admin dapat menentukan status pembayaran menjadi valid atau invalid. Status valid digunakan ketika pembayaran diterima, sedangkan status invalid digunakan ketika pembayaran ditolak. Proses verifikasi juga mencatat waktu verifikasi pada database.

Method `verifikasi()` pada `Pembayaran_model.php` diperbarui untuk memastikan hanya pembayaran dengan status pending yang dapat diverifikasi. Selain itu, dilakukan pemeriksaan jumlah data yang berhasil diperbarui agar proses verifikasi tidak dianggap berhasil apabila tidak ada data pembayaran yang berubah.

**Hasil:** Fungsi verifikasi pembayaran Admin berhasil ditambahkan pada controller dan method verifikasi model diperbarui. Syntax check controller dan model dilakukan untuk memastikan tidak terdapat kesalahan sintaks. Integrasi tombol verifikasi dan routes akan dilanjutkan pada tahap berikutnya.

## Halaman Pembayaran Saya (Penyewa)

Pada tahap ini, saya membuat halaman **Pembayaran Saya** yang digunakan penyewa untuk melihat daftar pembayaran dari transaksi rental mobil yang telah dilakukan. Data pembayaran diambil berdasarkan username penyewa yang sedang login, sehingga penyewa hanya dapat melihat pembayaran miliknya sendiri.

Pada halaman ini, informasi yang ditampilkan meliputi kode pembayaran, kode sewa, tanggal pembayaran, jenis pembayaran (DP atau pelunasan), nominal pembayaran, metode pembayaran, status pembayaran, dan tombol detail untuk melihat informasi pembayaran lebih lanjut. Selain itu, tersedia tombol Kembali ke Katalog untuk memudahkan penyewa kembali melihat daftar mobil.

Saya juga melakukan perbaikan pada pengambilan data pembayaran di halaman view agar data yang dikirim oleh controller dapat ditampilkan dengan benar. Sebelumnya, halaman menampilkan pesan “Belum ada data pembayaran” meskipun data pembayaran sudah tersedia. Hal tersebut terjadi karena nama variabel yang digunakan pada view tidak sesuai dengan nama variabel yang dikirim oleh controller. Setelah diperbaiki, data pembayaran berhasil ditampilkan pada halaman Pembayaran Saya.

**Hasil pengujian:** halaman Pembayaran Saya berhasil menampilkan data pembayaran penyewa, termasuk pembayaran dengan status Menunggu Verifikasi, Tidak Valid, dan Valid. Tombol Detail dan Kembali ke Katalog juga tersedia pada halaman tersebut. Pengujian dilakukan tanpa mengubah struktur database yang telah disediakan oleh dosen.

### Perbaikan Detail Pembayaran Penyewa

Pada tahap ini, saya memperbaiki tombol Detail pada halaman Pembayaran Saya yang sebelumnya mengalami Not Found. Permasalahan terjadi karena kode pembayaran memiliki karakter garis miring (/) sehingga tidak dapat diproses dengan benar melalui route yang sebelumnya digunakan.

Perbaikan dilakukan dengan menggunakan query string untuk mengirim kode pembayaran dari halaman daftar pembayaran ke controller. Controller kemudian mengambil kode pembayaran dari query string dan menampilkan detail pembayaran sesuai dengan transaksi milik penyewa yang sedang login.

**Hasil pengujian:** tombol Detail berhasil membuka halaman Detail Pembayaran dan menampilkan kode pembayaran, kode sewa, tanggal pembayaran, jenis pembayaran, nominal, metode pembayaran, status pembayaran, status sewa, serta fitur upload bukti pembayaran. Pengujian berhasil dilakukan tanpa mengubah struktur database.

### Upload Bukti Pembayaran

Pada tahap ini dilakukan perbaikan fitur upload foto bukti pembayaran pada halaman detail pembayaran penyewa. Sebelumnya, fitur upload mengalami error karena konstanta `ROOTPATH` belum tersedia pada project. Oleh karena itu, lokasi folder upload diperbaiki dengan menggunakan path direktori project.

Fitur upload bukti pembayaran menggunakan metode POST dan `multipart/form-data`. File yang dapat diunggah berupa JPG, JPEG, PNG, atau WEBP dengan ukuran maksimal 5 MB. File bukti pembayaran disimpan pada folder `uploads/pembayaran/`, sedangkan nama file disimpan ke database.

Pengujian dilakukan dengan mengunggah foto bukti transfer melalui halaman detail pembayaran penyewa. Hasil pengujian menunjukkan bahwa foto bukti berhasil diunggah, tersimpan pada folder upload, dan dapat ditampilkan pada detail pembayaran penyewa maupun admin.

**Hasil pengujian: Berhasil.**

### Manajemen Pembayaran Admin

Pada tahap ini dilakukan perbaikan fitur Manajemen Pembayaran Admin. Daftar pembayaran tidak lagi dibatasi hanya tiga data, tetapi menampilkan seluruh pembayaran dari penyewa yang masih perlu diproses oleh Admin.

Ketika penyewa melakukan checkout, data pembayaran otomatis masuk ke daftar Manajemen Pembayaran Admin, meskipun penyewa belum mengunggah bukti pembayaran. Setelah penyewa mengunggah bukti, Admin dapat melihat detail pembayaran dan melakukan verifikasi.

Apabila Admin menerima pembayaran dan mengubah status menjadi Valid, pembayaran tersebut otomatis hilang dari daftar pembayaran Admin yang masih perlu diproses. Data pembayaran tetap tersimpan di database sehingga riwayat pembayaran penyewa tidak terhapus.

**Hasil pengujian:** seluruh alur checkout, tampilnya pembayaran di Admin, upload bukti, verifikasi pembayaran, dan hilangnya pembayaran berstatus Valid dari daftar Admin berhasil dilakukan.
