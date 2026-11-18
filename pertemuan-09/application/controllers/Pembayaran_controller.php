<?php

require_once APPPATH . 'models/Pembayaran_model.php';

class Pembayaran_controller extends Controller
{
    private Pembayaran_model $model;

    public function __construct()
    {
        $this->model = new Pembayaran_model();
    }

    // =====================================================
    // P9: DAFTAR PEMBAYARAN PENYEWA
    // =====================================================
    public function index(): void
    {
        $userPlg = $this->wajibLoginPenyewa();

        try {
            $daftarPembayaran = $this->model->getByPenyewa($userPlg);

            $flash = $_SESSION['flash_pembayaran'] ?? null;
            unset($_SESSION['flash_pembayaran']);

            $this->view('pembayaran/index', [
                'daftarPembayaran' => $daftarPembayaran,
                'flash' => $flash,
                'error' => null
            ]);
        } catch (Throwable $e) {
            error_log(
                'Daftar pembayaran Penyewa gagal: '
                . $e->getMessage()
            );

            http_response_code(500);

            exit('Daftar pembayaran belum dapat ditampilkan.');
        }
    }

    // =====================================================
    // P9: DETAIL PEMBAYARAN PENYEWA
    // =====================================================
   public function detail(): void
{
    $userPlg = $this->wajibLoginPenyewa();

    // Mengambil kode pembayaran dari query string
    $kodeBayar = trim(
        (string) ($_GET['kode_bayar'] ?? '')
    );

    if ($kodeBayar === '') {
        http_response_code(400);
        exit('Kode pembayaran tidak tersedia.');
    }

    try {
        $detail = $this->model->getDetailPenyewa(
            $kodeBayar,
            $userPlg
        );

        if ($detail === null) {
            http_response_code(404);
            exit('Data pembayaran tidak ditemukan.');
        }

        $flash = $_SESSION['flash_pembayaran'] ?? null;
        unset($_SESSION['flash_pembayaran']);

        $this->view('pembayaran/detail', [
            'pembayaran' => $detail,
            'flash' => $flash,
            'error' => null
        ]);
    } catch (Throwable $e) {
        error_log(
            'Detail pembayaran Penyewa gagal: '
            . $e->getMessage()
        );

        http_response_code(500);

        exit('Detail pembayaran belum dapat ditampilkan.');
    }
}

    // =====================================================
    // P9: UPLOAD BUKTI PEMBAYARAN PENYEWA
    // =====================================================
    public function uploadBukti(): void
{
    $userPlg = $this->wajibLoginPenyewa();

    // Mengambil kode pembayaran dari query string.
    $kodeBayar = trim(
        (string) ($_GET['kode_bayar'] ?? '')
    );

    // Memastikan kode pembayaran tersedia.
    if ($kodeBayar === '') {
        http_response_code(400);
        exit('Kode pembayaran tidak tersedia.');
    }

        // Upload bukti hanya melalui POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');

            exit('Metode permintaan tidak diizinkan.');
        }

        // Memastikan file dikirim.
        if (
            !isset($_FILES['ft_byr'])
            || $_FILES['ft_byr']['error'] !== UPLOAD_ERR_OK
        ) {
            $_SESSION['flash_pembayaran'] = [
                'type' => 'error',
                'message' => 'Bukti pembayaran gagal diunggah.'
            ];

            $this->redirectDetailPenyewa($kodeBayar);
        }

        $file = $_FILES['ft_byr'];

        // Batas ukuran file 5 MB.
        $maksimalUkuran = 5 * 1024 * 1024;

        if ($file['size'] > $maksimalUkuran) {
            $_SESSION['flash_pembayaran'] = [
                'type' => 'error',
                'message' => 'Ukuran bukti pembayaran maksimal 5 MB.'
            ];

            $this->redirectDetailPenyewa($kodeBayar);
        }

        // Memastikan file merupakan gambar yang diperbolehkan.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $mimeDiizinkan = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];

        if (!isset($mimeDiizinkan[$mimeType])) {
            $_SESSION['flash_pembayaran'] = [
                'type' => 'error',
                'message' => 'Format bukti harus JPG, PNG, atau WEBP.'
            ];

            $this->redirectDetailPenyewa($kodeBayar);
        }

        // Membuat folder upload jika belum tersedia.
$folderUpload = dirname(__DIR__, 2)
    . DIRECTORY_SEPARATOR
    . 'uploads'
    . DIRECTORY_SEPARATOR
    . 'pembayaran'
    . DIRECTORY_SEPARATOR;

        if (
            !is_dir($folderUpload)
            && !mkdir($folderUpload, 0755, true)
            && !is_dir($folderUpload)
        ) {
            $_SESSION['flash_pembayaran'] = [
                'type' => 'error',
                'message' => 'Folder upload bukti pembayaran gagal dibuat.'
            ];

            $this->redirectDetailPenyewa($kodeBayar);
        }

        // Nama file dibuat unik agar tidak menimpa file lain.
        $namaFile = bin2hex(random_bytes(16))
            . '.'
            . $mimeDiizinkan[$mimeType];

        $lokasiFile = $folderUpload . $namaFile;

        // Memindahkan file upload ke folder aplikasi.
        if (!move_uploaded_file($file['tmp_name'], $lokasiFile)) {
            $_SESSION['flash_pembayaran'] = [
                'type' => 'error',
                'message' => 'Bukti pembayaran gagal disimpan.'
            ];

            $this->redirectDetailPenyewa($kodeBayar);
        }

        try {
           // Menyimpan nama file bukti ke database.
$berhasil = $this->model->updateBukti(
    $kodeBayar,
    $userPlg,
    $namaFile
);

if ($berhasil) {
    $_SESSION['flash_pembayaran'] = [
        'type' => 'success',
        'message' => 'Bukti pembayaran berhasil diunggah.'
    ];
} else {
    // Menghapus file jika penyimpanan database gagal.
    if (is_file($lokasiFile)) {
        unlink($lokasiFile);
    }

    $_SESSION['flash_pembayaran'] = [
        'type' => 'error',
        'message' => 'Bukti gagal disimpan atau pembayaran tidak ditemukan.'
    ];
}
        } catch (Throwable $e) {
            // Menghapus file jika terjadi error database.
            if (is_file($lokasiFile)) {
                unlink($lokasiFile);
            }

            error_log(
                'Upload bukti pembayaran gagal: '
                . $e->getMessage()
            );

            $_SESSION['flash_pembayaran'] = [
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan bukti pembayaran.'
            ];
        }

        $this->redirectDetailPenyewa($kodeBayar);
    }

    // =====================================================
    // P9: DAFTAR PEMBAYARAN ADMIN
    // =====================================================
    public function indexAdmin(): void
    {
        require_once APPPATH . 'helpers/auth_helper.php';
        require_admin_login();

        try {
            $daftarPembayaran = $this->model->getAll();

            $flash = $_SESSION['flash_pembayaran_admin'] ?? null;
            unset($_SESSION['flash_pembayaran_admin']);

            $this->view('admin/pembayaran/index', [
                'daftarPembayaran' => $daftarPembayaran,
                'flash' => $flash,
                'error' => null
            ]);
        } catch (Throwable $e) {
            error_log(
                'Daftar pembayaran Admin gagal: '
                . $e->getMessage()
            );

            http_response_code(500);

            exit('Daftar pembayaran belum dapat ditampilkan.');
        }
    }

    // =====================================================
    // P9: DETAIL PEMBAYARAN ADMIN
    // Menggunakan query string kode_bayar
    // =====================================================
    public function detailAdmin(): void
    {
        require_once APPPATH . 'helpers/auth_helper.php';
        require_admin_login();

        // Mengambil kode pembayaran dari query string.
        $kodeBayar = trim($_GET['kode_bayar'] ?? '');

        if ($kodeBayar === '') {
            http_response_code(400);

            exit('Kode pembayaran tidak ditemukan.');
        }

        try {
            $detail = $this->model->getDetailAdmin($kodeBayar);

            if ($detail === null) {
                http_response_code(404);

                exit('Data pembayaran tidak ditemukan.');
            }

            $flash = $_SESSION['flash_pembayaran_admin'] ?? null;
            unset($_SESSION['flash_pembayaran_admin']);

            $this->view('admin/pembayaran/detail', [
                'pembayaran' => $detail,
                'flash' => $flash,
                'error' => null
            ]);
        } catch (Throwable $e) {
            error_log(
                'Detail pembayaran Admin gagal: '
                . $e->getMessage()
            );

            http_response_code(500);

            exit('Detail pembayaran belum dapat ditampilkan.');
        }
    }

    // =====================================================
    // P9: VERIFIKASI PEMBAYARAN ADMIN
    // Menggunakan query string kode_bayar
    // =====================================================
    public function verifikasiAdmin(): void
    {
        require_once APPPATH . 'helpers/auth_helper.php';
        require_admin_login();

        // Verifikasi hanya diperbolehkan melalui POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');

            exit('Metode permintaan tidak diizinkan.');
        }

        // Mengambil kode pembayaran dari query string.
        $kodeBayar = trim($_GET['kode_bayar'] ?? '');

        if ($kodeBayar === '') {
            http_response_code(400);

            exit('Kode pembayaran tidak ditemukan.');
        }

        // Mengambil status dari tombol yang ditekan.
        $status = $_POST['status'] ?? '';

        // Memvalidasi status yang dipilih Admin.
        if (!in_array($status, ['valid', 'invalid'], true)) {
            $_SESSION['flash_pembayaran_admin'] = [
                'type' => 'error',
                'message' => 'Status verifikasi tidak valid.'
            ];

            $this->redirectDetailAdmin($kodeBayar);
        }

        try {
            $berhasil = $this->model->verifikasi(
                $kodeBayar,
                $status
            );

            if ($berhasil) {
                $_SESSION['flash_pembayaran_admin'] = [
                    'type' => 'success',
                    'message' => $status === 'valid'
                        ? 'Pembayaran berhasil diterima.'
                        : 'Pembayaran berhasil ditolak.'
                ];
            } else {
                $_SESSION['flash_pembayaran_admin'] = [
                    'type' => 'error',
                    'message' => 'Pembayaran gagal diverifikasi atau sudah diverifikasi sebelumnya.'
                ];
            }
        } catch (Throwable $e) {
            error_log(
                'Verifikasi pembayaran Admin gagal: '
                . $e->getMessage()
            );

            $_SESSION['flash_pembayaran_admin'] = [
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat memverifikasi pembayaran.'
            ];
        }

        // Kembali ke halaman detail pembayaran yang sama.
        $this->redirectDetailAdmin($kodeBayar);
    }

    // =====================================================
    // P9: MEMASTIKAN PENYEWA SUDAH LOGIN
    // =====================================================
    private function wajibLoginPenyewa(): string
    {
        $userPlg = $_SESSION['penyewa_user_plg'] ?? '';

        if ($userPlg === '') {
            $_SESSION['flash_penyewa_nav'] =
                'Silakan login terlebih dahulu untuk mengakses pembayaran.';

            header(
                'Location: '
                . site_url('auth/login-penyewa')
            );

            exit;
        }

        return $userPlg;
    }

    // =====================================================
    // P9: REDIRECT KE DETAIL PEMBAYARAN PENYEWA
    // =====================================================
   private function redirectDetailPenyewa(string $kodeBayar): void
{
    header(
        'Location: '
        . site_url(
            'pembayaran/detail?kode_bayar='
            . rawurlencode($kodeBayar)
        )
    );

    exit;
}

    // =====================================================
    // P9: REDIRECT KE DETAIL PEMBAYARAN ADMIN
    // Menggunakan query string agar kode dengan "/" aman
    // =====================================================
    private function redirectDetailAdmin(string $kodeBayar): void
    {
        header(
            'Location: '
            . site_url(
                'admin/pembayaran/detail?kode_bayar='
                . rawurlencode($kodeBayar)
            )
        );

        exit;
    }
}
