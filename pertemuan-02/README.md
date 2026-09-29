## 1. Tujuan Praktikum 
[ 1. Tujuan Praktikum
Praktikum P2 bertujuan untuk memahami dan membangun dasar aplikasi web menggunakan konsep MVC secara sederhana tanpa framework. Pada praktikum ini, mahasiswa belajar membuat struktur proyek, front controller, routing, Base URL, Helper, Controller, dan View. Selain itu, mahasiswa diharapkan memahami alur request-response dari browser → `index.php` → Router → Controller → View → Response serta mampu menerapkan routing dan parameter pada aplikasi yang dibuat.]

## 2. Struktur Direktori 
[dpwl-nim/
├── application/
│   ├── config/
│   │   ├── config.php
│   │   └── routes.php
│   ├── controllers/
│   │   └── Home.php
│   ├── helpers/
│   │   └── url_helper.php
│   └── views/
│       └── home/
│           ├── index.php
│           └── info.php
│
├── assets/
│   └── css/
│       └── app.css
│
├── system/
│   └── core/
│       ├── Controller.php
│       └── Router.php
│
└── index.php.]  

| Bagian                       | Fungsi singkat                                                       |
| ---------------------------- | -------------------------------------------------------------------- |
| `application/`               | Menyimpan bagian utama aplikasi.                                     |
| `config.php`                 | Mengatur konfigurasi aplikasi dan `base_url`.                        |
| `routes.php`                 | Mengatur pemetaan URL ke Controller dan method.                      |
| `controllers/Home.php`       | Mengolah request dan menentukan View yang ditampilkan.               |
| `helpers/url_helper.php`     | Membantu membuat URL aplikasi dan navigasi.                          |
| `views/`                     | Menyimpan tampilan/HTML yang dilihat pengguna.                       |
| `assets/css/app.css`         | Mengatur tampilan dan style halaman.                                 |
| `system/core/Controller.php` | Base Controller untuk membantu memanggil View.                       |
| `system/core/Router.php`     | Menentukan Controller, method, dan parameter dari URL.               |
| `index.php`                  | Sebagai pintu masuk utama (front controller) semua request aplikasi. |


## 3. Front controller 
[index.php berperan sebagai satu pintu masuk utama (front controller) dalam aplikasi P2. Jadi, request dari browser untuk fitur atau route aplikasi akan masuk terlebih dahulu ke index.php..

Tugasnya :
menerima request → memuat konfigurasi, Helper, dan class inti → mengambil route → menyerahkan request ke Router.

Contohnya, saat membuka:

http://localhost/dpwl-nim/index.php/info/routing]  

## 4. Routing dan Pemetaan URL
 | URL/Route | Controller | Method | Parameter | View | |---|---|---|---|---| | / | Home | index | - | home/index.php | | home/index | Home | index | - | home/index.php | | home/info/mvc | Home | info | mvc | home/info.php | | info/routing | Home | info | routing | home/info.php |  
 
 Tambahkan satu baris untuk route hasil Tahap Modifikasi ATM yang dibuat berdasarkan objek atau konteks aplikasi DPW, kemudian jelaskan pemetaan route → Controller → method → parameter → View.  

 | URL/Route           | Controller | Method | Parameter  | View           |
| ------------------- | ---------- | ------ | ---------- | -------------- |
| `/`                 | Home       | index  | -          | home/index.php |
| `home/index`        | Home       | index  | -          | home/index.php |
| `home/info/mvc`     | Home       | info   | mvc        | home/info.php  |
| `info/routing`      | Home       | info   | routing    | home/info.php  |
| `mobil/info/(:any)` | Mobil      | info   | nama_mobil | mobil/info.php |
Penjelasan pemetaan:

mobil/info/(:any) → Controller Mobil → method info() → parameter nama_mobil → View mobil/info.php

Artinya, ketika user membuka misalnya:

index.php/mobil/info/avanza
  
 ## 5. Base URL dan Helper 
 Jelaskan fungsi base_url() dan site_url(), kemudian berikan contoh penggunaannya pada implementasi P2:  
 - base_url() untuk memanggil assets/css/app.css;  
 - site_url() untuk membentuk URL navigasi/route aplikasi.  

 base_url() berfungsi untuk membuat alamat dasar aplikasi, terutama untuk memanggil file seperti CSS, JavaScript, dan gambar. Pada P2, base_url() digunakan untuk memanggil assets/css/app.css.
 contoh :
 <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
 hasilnya:
 http://localhost/dpwl-nim/assets/css/app.css

 site_url() berfungsi untuk membuat URL navigasi atau route aplikasi, sehingga link menuju Controller dan method tidak perlu ditulis secara hard-coded. Pada P2, fungsi ini digunakan untuk membentuk URL menuju route aplikasi.
 contoh:
 <a href="<?= site_url('info/routing') ?>">Uji Custom Route</a>
 hasilnya:
 http://localhost/dpwl-nim/index.php/info/routing
 
 ## 6. Alur Request-response 
 Jelaskan dua alur berikut:  
 
 1. Alur eksekusi aktual P2: 
 Browser → index.php → Router → Controller → View → Response. 
- Browser mengirim request atau permintaan ke aplikasi.
- index.php menjadi pintu masuk utama untuk menerima request dan menyiapkan komponen aplikasi.
- Router membaca URL/URI lalu menentukan Controller, method, dan parameter yang harus dijalankan.
- Controller memproses request dan menentukan View yang digunakan.
- View menampilkan data atau halaman dalam bentuk HTML.
- Response berupa hasil halaman dikirim kembali ke browser untuk ditampilkan.

 2. Posisi Model dalam arsitektur MVC lengkap: Browser → index.php → Router → Controller → Model → basis data/data → Model → Controller → View → Response.  
 
 Pada implementasi P2, Model belum digunakan karena akses dan pengelolaan basis data mulai diimplementasikan pada P3.
 "Pada MVC lengkap, Model berfungsi sebagai bagian yang mengatur pengelolaan data. Setelah request sampai ke Controller, Controller dapat meminta Model mengambil atau mengolah data dari basis data. Data tersebut kemudian dikembalikan dari Model ke Controller, lalu Controller mengirimkannya ke View untuk ditampilkan kepada pengguna."  
 
 ## 7. Hasil Pengujian dan Debugging 
 Catat skenario pengujian valid dan tidak valid beserta hasilnya. Jika ditemukan kesalahan selama implementasi, dokumentasikan sekurang-kurangnya satu proses debugging yang memuat:  
 
 Gejala → Penyebab → Perbaikan → Hasil Uji Ulang  
 
 Jika seluruh implementasi langsung berjalan sesuai hasil yang diharapkan, jelaskan hasil pemeriksaan sintaks dan pengujian yang telah dilakukan.  

#### A. Pengujian Valid

| No | URL yang diuji             | Hasil yang diharapkan                                | Hasil Pengujian                    |
| -- | -------------------------- | ---------------------------------------------------- | ---------------------------------- |
| 1  | `/`                        | Menampilkan halaman utama melalui default controller | Berhasil, halaman utama tampil     |
| 2  | `/index.php/home/index`    | Memanggil `Home::index()`                            | Berhasil, halaman utama tampil     |
| 3  | `/index.php/home/info/mvc` | Memanggil `Home::info()` dengan parameter `mvc`      | Berhasil, parameter `mvc` tampil   |
| 4  | `/index.php/info/routing`  | Custom route diarahkan ke `Home::info('routing')`    | Berhasil, informasi routing tampil |

Pengujian valid menunjukkan bahwa routing, Controller, parameter, dan View sudah dapat berjalan sesuai dengan rancangan.

#### B. Pengujian Tidak Valid

| No | URL yang diuji             | Hasil yang diharapkan                                  | Hasil Pengujian                                      |
| -- | -------------------------- | ------------------------------------------------------ | ---------------------------------------------------- |
| 1  | `/index.php/tidakada`      | Menampilkan HTTP 404 karena Controller tidak ditemukan | Berhasil, muncul pesan “Controller tidak ditemukan.” |
| 2  | `/index.php/home/tidakada` | Menampilkan HTTP 404 karena method tidak ditemukan     | Berhasil, muncul pesan “Method tidak ditemukan.”     |

Pengujian ini dilakukan untuk memastikan aplikasi dapat menangani URL yang tidak sesuai dan memberikan pesan error yang tepat.

#### C. Debugging

Contoh proses debugging yang dilakukan:

**Gejala:**
Halaman `home/info` tidak dapat ditampilkan dan muncul pesan **“View tidak ditemukan.”**

**Penyebab:**
File `application/views/home/info.php` tidak ditemukan atau nama/path file View tidak sesuai dengan yang dipanggil oleh Controller.

**Perbaikan:**
Memeriksa kembali path View pada Controller dan memastikan file `info.php` berada di folder `application/views/home/`.

**Hasil Uji Ulang:**
Setelah file dan path diperbaiki, URL `/index.php/home/info/mvc` dapat dijalankan dan parameter `mvc` berhasil ditampilkan pada halaman.

Modul menjelaskan bahwa error View terjadi ketika Controller sudah berhasil dijalankan tetapi file View yang dibutuhkan tidak tersedia atau path-nya tidak sesuai.

#### D. Pemeriksaan Sintaks

Selain pengujian melalui browser, dilakukan pemeriksaan sintaks PHP menggunakan perintah `php -l` pada file-file utama P2, seperti `index.php`, `config.php`, `routes.php`, `url_helper.php`, `Home.php`, `Controller.php`, dan `Router.php`.

Hasil pemeriksaan menunjukkan **“No syntax errors detected”**, sehingga tidak ditemukan kesalahan sintaks PHP. Setelah itu, pengujian routing dijalankan kembali untuk memastikan fungsi aplikasi berjalan sesuai yang diharapkan.

 
 ## 8. Bukti Tangkapan Layar 
 Sisipkan gambar yang relevan dari folder dokumentasi/ dengan perintah:  
 ### Gambar 1. Hasil Pengujian Halaman Utama  
 ![Gambar 1 - Halaman Utama](dokumentasi/gambar1.jpg)   
 
 ### Gambar 2. Hasil Pengujian Custom Route  
 ![Gambar 2 - Custom Route](dokumentasi/gambar2.jpg)  
 
 ## 9. Kesimpulan P2 Jelaskan apa yang sudah dapat dilakukan kerangka MVC dan apa yang baru akan ditambahkan pada P3.
 Pada praktikum P2, saya sudah dapat membuat kerangka dasar MVC sederhana tanpa menggunakan framework. Kerangka tersebut sudah dapat menjalankan index.php sebagai front controller, melakukan routing dari URL ke Controller dan method, menggunakan parameter, serta menampilkan hasil melalui View. Selain itu, base_url() dan site_url() juga sudah dapat digunakan untuk mengatur URL aset dan navigasi aplikasi.

Pada P2, Model dan database belum digunakan karena fokusnya masih pada fondasi MVC dan alur request-response. Pada P3, kerangka ini akan dikembangkan dengan menambahkan Model, koneksi basis data, MySQLi/prepared statement, autentikasi, sesi, kontrol akses, serta integrasi AdminLTE. 