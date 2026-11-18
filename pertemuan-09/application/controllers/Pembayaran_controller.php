<?php

class Pembayaran_controller extends Controller
{
    private Pembayaran_model $model;

    public function __construct()
    {
        require_once APPPATH . 'models/Pembayaran_model.php';

        $this->model = new Pembayaran_model();
    }

    // P9: Menampilkan daftar pembayaran penyewa
    public function index(): void
    {
        $this->wajibLoginPenyewa();

        $userPlg = $_SESSION['penyewa_user_plg'];

        try {
            $dataPembayaran = $this->model->getByPenyewa($userPlg);

            $flash = $_SESSION['flash_pembayaran'] ?? null;
            unset($_SESSION['flash_pembayaran']);

            $this->view('pembayaran/index', [
                'pembayaran' => $dataPembayaran,
                'flash' => $flash,
                'error' => null
            ]);
        } catch (Throwable $e) {
            error_log(
                'Daftar pembayaran penyewa gagal: ' . $e->getMessage()
            );

            $this->view('pembayaran/index', [
                'pembayaran' => [],
                'flash' => null,
                'error' => 'Data pembayaran belum dapat ditampilkan.'
            ]);
        }
    }

    // P9: Menampilkan detail pembayaran penyewa
   public function detail(string $kodeBayar): void
{
    $this->wajibLoginPenyewa();

    $userPlg = $_SESSION['penyewa_user_plg'];

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
            'Detail pembayaran penyewa gagal: '
            . $e->getMessage()
        );

        http_response_code(500);
        exit('Detail pembayaran belum dapat ditampilkan.');
    }
}

    // P9: Memastikan penyewa sudah login
    private function wajibLoginPenyewa(): void
    {
        if (
            !isset($_SESSION['penyewa_user_plg']) ||
            $_SESSION['penyewa_user_plg'] === ''
        ) {
            header(
                'Location: ' . site_url('auth/login-penyewa')
            );
            exit;
        }
    }
    public function uploadBukti(string $kodeBayar): void
{
    $this->wajibLoginPenyewa();

    $userPlg = $_SESSION['penyewa_user_plg'];

    // Pastikan pembayaran milik penyewa yang sedang login.
    $detail = $this->model->getDetailPenyewa(
        $kodeBayar,
        $userPlg
    );

    if ($detail === null) {
        http_response_code(404);
        exit('Data pembayaran tidak ditemukan.');
    }

    // Upload hanya diperbolehkan untuk transfer
    // dengan status pending atau invalid.
    if (
        $detail['mtode_byr'] !== 'transfer'
        || !in_array(
            $detail['sttus_byr'],
            ['pending', 'invalid'],
            true
        )
    ) {
        $_SESSION['flash_pembayaran'] = [
            'type' => 'error',
            'message' => 'Pembayaran tidak dapat menerima bukti upload.'
        ];

        header(
            'Location: '
            . site_url(
                'pembayaran_controller/detail/'
                . rawurlencode($kodeBayar)
            )
        );
        exit;
    }

    // Pastikan file dikirim melalui form.
    if (
        !isset($_FILES['ft_byr'])
        || $_FILES['ft_byr']['error'] !== UPLOAD_ERR_OK
    ) {
        $_SESSION['flash_pembayaran'] = [
            'type' => 'error',
            'message' => 'Silakan pilih file bukti pembayaran.'
        ];

        header(
            'Location: '
            . site_url(
                'pembayaran_controller/detail/'
                . rawurlencode($kodeBayar)
            )
        );
        exit;
    }

    $file = $_FILES['ft_byr'];

    // Maksimal ukuran file 5 MB.
    if ($file['size'] > 5 * 1024 * 1024) {
        $_SESSION['flash_pembayaran'] = [
            'type' => 'error',
            'message' => 'Ukuran file maksimal 5 MB.'
        ];

        header(
            'Location: '
            . site_url(
                'pembayaran_controller/detail/'
                . rawurlencode($kodeBayar)
            )
        );
        exit;
    }

    // Validasi MIME file.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $mimeAllowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    if (!isset($mimeAllowed[$mime])) {
        $_SESSION['flash_pembayaran'] = [
            'type' => 'error',
            'message' => 'File harus berupa JPG, PNG, atau WEBP.'
        ];

        header(
            'Location: '
            . site_url(
                'pembayaran_controller/detail/'
                . rawurlencode($kodeBayar)
            )
        );
        exit;
    }

    // Membuat folder upload jika belum tersedia.
    $folderUpload = ROOTPATH . 'uploads/pembayaran/';

    if (
        !is_dir($folderUpload)
        && !mkdir($folderUpload, 0755, true)
    ) {
        $_SESSION['flash_pembayaran'] = [
            'type' => 'error',
            'message' => 'Folder upload bukti pembayaran gagal dibuat.'
        ];

        header(
            'Location: '
            . site_url(
                'pembayaran_controller/detail/'
                . rawurlencode($kodeBayar)
            )
        );
        exit;
    }

    // Nama file dibuat unik agar tidak bertabrakan.
    $namaFile = 'bukti_'
        . bin2hex(random_bytes(16))
        . '.'
        . $mimeAllowed[$mime];

    $tujuanFile = $folderUpload . $namaFile;

    if (!move_uploaded_file(
        $file['tmp_name'],
        $tujuanFile
    )) {
        $_SESSION['flash_pembayaran'] = [
            'type' => 'error',
            'message' => 'Bukti pembayaran gagal diunggah.'
        ];

        header(
            'Location: '
            . site_url(
                'pembayaran_controller/detail/'
                . rawurlencode($kodeBayar)
            )
        );
        exit;
    }

    // Simpan nama file ke database.
    try {
        $berhasil = $this->model->updateBukti(
            $kodeBayar,
            $userPlg,
            $namaFile
        );

        if (!$berhasil) {
            // Hapus file apabila database gagal diperbarui.
            if (is_file($tujuanFile)) {
                unlink($tujuanFile);
            }

            $_SESSION['flash_pembayaran'] = [
                'type' => 'error',
                'message' => 'Bukti pembayaran gagal disimpan.'
            ];
        } else {
            $_SESSION['flash_pembayaran'] = [
                'type' => 'success',
                'message' => 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi Admin.'
            ];
        }
    } catch (Throwable $e) {
        error_log(
            'Upload bukti pembayaran gagal: '
            . $e->getMessage()
        );

        if (is_file($tujuanFile)) {
            unlink($tujuanFile);
        }

        $_SESSION['flash_pembayaran'] = [
            'type' => 'error',
            'message' => 'Terjadi kesalahan saat menyimpan bukti pembayaran.'
        ];
    }

    header(
        'Location: '
        . site_url(
            'pembayaran_controller/detail/'
            . rawurlencode($kodeBayar)
        )
    );
    exit;
}
// P9: Proses verifikasi pembayaran oleh Admin
public function verifikasiAdmin(string $kodeBayar): void
{
    // Memastikan hanya Admin yang login dapat melakukan verifikasi.
    require_once APPPATH . 'helpers/auth_helper.php';
    require_admin_login();

    // Verifikasi hanya boleh dilakukan melalui POST.
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Metode permintaan tidak diizinkan.');
    }

    // Mengambil status yang dipilih Admin.
    $status = $_POST['status'] ?? '';

    // Validasi status verifikasi.
    if (!in_array($status, ['valid', 'invalid'], true)) {
        $_SESSION['flash_pembayaran_admin'] = [
            'type' => 'error',
            'message' => 'Status verifikasi tidak valid.'
        ];

        header('Location: ' . site_url('admin/pembayaran'));
        exit;
    }

    try {
        // Memproses verifikasi melalui model.
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
                'message' => 'Pembayaran gagal diverifikasi.'
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

    // Kembali ke daftar pembayaran Admin.
    header('Location: ' . site_url('admin/pembayaran'));
    exit;
}
}