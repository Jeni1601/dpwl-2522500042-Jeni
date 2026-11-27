
<?php

require_once APPPATH . 'models/SerahTerima_model.php';

class SerahTerima_controller extends Controller
{
    private SerahTerima_model $model;

    public function __construct()
    {
        require_once APPPATH . 'helpers/auth_helper.php';

        $this->model = new SerahTerima_model();
    }

    /**
     * Menampilkan daftar transaksi yang siap diserahterimakan.
     */
    public function index(): void
    {
        require_admin_login();
        $this->wajibMetode('GET');

        $daftarSerahTerima = [];
        $flash = $_SESSION['flash_serah_terima'] ?? null;

        unset($_SESSION['flash_serah_terima']);

        try {
            $daftarSerahTerima = $this->model
                ->getDaftarSerahTerima();

        } catch (Throwable $e) {

            error_log(
                'Daftar serah terima gagal ditampilkan: '
                . $e->getMessage()
            );

            $flash = [
                'type' => 'error',
                'message' => 'Data serah terima gagal diambil. '
                    . 'Silakan periksa koneksi dan struktur database.'
            ];
        }

        $this->view('admin/serah_terima', [
            'username' => $_SESSION['admin_username'] ?? 'Admin',
            'daftarSerahTerima' => $daftarSerahTerima,
            'flash' => $flash
        ]);
    }

    /**
     * Menampilkan detail transaksi yang akan diserahterimakan.
     */
    public function detail(string $kodeSewa = ''): void
    {
        require_admin_login();
        $this->wajibMetode('GET');

        $kodeSewa = trim(
            str_replace('~', '/', $kodeSewa)
        );

        if ($kodeSewa === '') {
            http_response_code(400);
            exit('Kode transaksi sewa wajib tersedia.');
        }

        try {
            $detail = $this->model
                ->getDetailSerahTerima($kodeSewa);

            if ($detail === null) {
                http_response_code(404);
                exit('Data transaksi tidak ditemukan.');
            }

            $flash = $_SESSION['flash_serah_terima'] ?? null;

            unset($_SESSION['flash_serah_terima']);

            $this->view('admin/serah_terima_detail', [
                'username' => $_SESSION['admin_username'] ?? 'Admin',
                'detail' => $detail,
                'daftarKendaraan' => $detail['daftar_kendaraan'],
                'flash' => $flash
            ]);

        } catch (Throwable $e) {

            error_log(
                'Detail serah terima gagal ditampilkan: '
                . $e->getMessage()
            );

            http_response_code(500);

            exit(
                'Detail serah terima belum dapat ditampilkan. '
                . 'Silakan periksa log aplikasi.'
            );
        }
    }

    /**
     * Memproses serah terima seluruh kendaraan dalam satu transaksi.
     *
     * KTP dan SIM A wajib tersedia sebelum proses dilanjutkan.
     */
    public function proses(string $kodeSewa = ''): void
    {
        require_admin_login();
        $this->wajibMetode('POST');

        $kodeSewa = trim(
            str_replace('~', '/', $kodeSewa)
        );

        if ($kodeSewa === '') {
            http_response_code(400);
            exit('Kode transaksi sewa wajib tersedia.');
        }

        $detailUrl = 'admin/serah-terima/detail/'
            . str_replace('/', '~', $kodeSewa);

        $detailSebelum = null;
        $fileBaru = [];

        try {

            /*
             * 1. Mengambil detail transaksi sebelum diproses.
             */
            $detailSebelum = $this->model
                ->getDetailSerahTerima($kodeSewa);

            if ($detailSebelum === null) {
                throw new DomainException(
                    'Data transaksi tidak ditemukan.'
                );
            }

            /*
             * 2. Mengunggah dokumen KTP.
             */
            $uploadKtp = $this->uploadDokumenPenyewa('ft_ktp');

            if (!$uploadKtp['success']) {
                $this->redirectDenganPesan(
                    $detailUrl,
                    'error',
                    $uploadKtp['error']
                );
            }

            if ($uploadKtp['filename'] !== null) {
                $fileBaru['ft_ktp'] = $uploadKtp['filename'];
            }

            /*
             * 3. Mengunggah dokumen SIM A.
             */
            $uploadSim = $this->uploadDokumenPenyewa('ft_sim_a');

            if (!$uploadSim['success']) {

                $this->hapusFileBaru($fileBaru);

                $this->redirectDenganPesan(
                    $detailUrl,
                    'error',
                    $uploadSim['error']
                );
            }

            if ($uploadSim['filename'] !== null) {
                $fileBaru['ft_sim_a'] = $uploadSim['filename'];
            }

            /*
             * 4. Mengambil waktu aktual serah terima.
             */
            $waktuAktual = (new DateTimeImmutable(
                'now',
                new DateTimeZone('Asia/Jakarta')
            ))->format('H:i:s');

            /*
             * 5. Memproses serah terima melalui Model.
             */
            $this->model->prosesSerahTerima(
                $kodeSewa,
                $waktuAktual,
                $fileBaru['ft_ktp'] ?? null,
                $fileBaru['ft_sim_a'] ?? null
            );

            /*
             * 6. Menyiapkan file dokumen lama
             *    untuk dihapus setelah database berhasil diperbarui.
             */
            $fileLama = [];

            foreach (['ft_ktp', 'ft_sim_a'] as $field) {

                $namaBaru = $fileBaru[$field] ?? null;
                $namaLama = $detailSebelum[$field] ?? null;

                if (
                    $namaBaru !== null &&
                    is_string($namaLama) &&
                    $namaLama !== '' &&
                    $namaLama !== $namaBaru
                ) {
                    $fileLama[$field] = $namaLama;
                }
            }

            /*
             * 7. Menghapus dokumen lama jika ada penggantian.
             */
            $this->hapusFileLama($fileLama);

            /*
             * 8. Mengarahkan kembali ke halaman daftar.
             */
            $this->redirectDenganPesan(
                'admin/serah-terima',
                'success',
                'Serah terima transaksi '
                    . $kodeSewa
                    . ' berhasil dicatat. '
                    . 'Status transaksi menjadi aktif.'
            );

        } catch (Throwable $e) {

            error_log(
                'Proses serah terima gagal untuk '
                . $kodeSewa . ': '
                . $e->getMessage()
            );

            /*
             * Menghapus file baru apabila proses gagal.
             */
            $this->hapusFileBaru($fileBaru);

            $pesan = $e instanceof DomainException
                ? $e->getMessage()
                : 'Serah terima gagal diproses. '
                    . 'Periksa kembali persyaratan transaksi '
                    . 'dan coba lagi.';

            $this->redirectDenganPesan(
                $detailUrl,
                'error',
                $pesan
            );
        }
    }

    /**
     * Memastikan metode HTTP sesuai dengan ketentuan.
     */
    private function wajibMetode(
        string $metodeDiizinkan
    ): void {
        $metodeAktif = strtoupper(
            (string) ($_SERVER['REQUEST_METHOD'] ?? 'GET')
        );

        if ($metodeAktif !== $metodeDiizinkan) {

            http_response_code(405);

            header('Allow: ' . $metodeDiizinkan);

            exit('Method Not Allowed');
        }
    }

    /**
     * Mengunggah dokumen KTP atau SIM A.
     *
     * Format: JPEG, PNG, WEBP.
     * Ukuran maksimum: 5 MB.
     */
    private function uploadDokumenPenyewa(
        string $field
    ): array {

        if (!in_array(
            $field,
            ['ft_ktp', 'ft_sim_a'],
            true
        )) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Jenis dokumen tidak valid.'
            ];
        }

        /*
         * Jika tidak ada file baru yang diunggah,
         * dokumen lama tetap digunakan.
         */
        if (
            !isset($_FILES[$field]) ||
            ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE)
                === UPLOAD_ERR_NO_FILE
        ) {
            return [
                'success' => true,
                'filename' => null,
                'error' => null
            ];
        }

        $file = $_FILES[$field];

        if (
            ($file['error'] ?? UPLOAD_ERR_NO_FILE)
            !== UPLOAD_ERR_OK
        ) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Unggah dokumen gagal. '
                    . 'Periksa ukuran file dan konfigurasi PHP.'
            ];
        }

        $tmpName = (string) ($file['tmp_name'] ?? '');
        $ukuran = (int) ($file['size'] ?? 0);

        if (
            $tmpName === '' ||
            !is_uploaded_file($tmpName) ||
            $ukuran < 1 ||
            $ukuran > 5 * 1024 * 1024
        ) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Dokumen harus berukuran lebih dari '
                    . '0 byte dan maksimal 5 MB.'
            ];
        }

        /*
         * Memastikan ekstensi Fileinfo tersedia.
         */
        if (!class_exists('finfo')) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Ekstensi Fileinfo PHP belum tersedia '
                    . 'pada server.'
            ];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $mime = $finfo->file($tmpName);

        $formatDiizinkan = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];

        if (
            !isset($formatDiizinkan[$mime]) ||
            @getimagesize($tmpName) === false
        ) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Format dokumen harus JPEG, PNG, '
                    . 'atau WEBP yang valid.'
            ];
        }

        /*
         * Folder penyimpanan dokumen penyewa.
         */
        $uploadDir = dirname(APPPATH)
            . DIRECTORY_SEPARATOR . 'uploads'
            . DIRECTORY_SEPARATOR . 'penyewa'
            . DIRECTORY_SEPARATOR;

        if (
            !is_dir($uploadDir) &&
            !mkdir($uploadDir, 0755, true) &&
            !is_dir($uploadDir)
        ) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Folder penyimpanan dokumen '
                    . 'penyewa tidak dapat dibuat.'
            ];
        }

        if (!is_writable($uploadDir)) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Folder penyimpanan dokumen '
                    . 'penyewa tidak dapat ditulis.'
            ];
        }

        /*
         * Membuat nama file unik.
         */
        try {

            $namaFile = $field
                . '_' . date('YmdHis')
                . '_' . bin2hex(random_bytes(8))
                . '.' . $formatDiizinkan[$mime];

        } catch (Throwable $e) {

            return [
                'success' => false,
                'filename' => null,
                'error' => 'Nama file dokumen gagal dibuat.'
            ];
        }

        /*
         * Memindahkan file ke folder uploads/penyewa.
         */
        if (!move_uploaded_file(
            $tmpName,
            $uploadDir . $namaFile
        )) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Dokumen gagal dipindahkan '
                    . 'ke folder penyimpanan.'
            ];
        }

        return [
            'success' => true,
            'filename' => $namaFile,
            'error' => null
        ];
    }

    /**
     * Menghapus file baru jika proses database gagal.
     */
    private function hapusFileBaru(array $files): void
    {
        foreach ($files as $field => $filename) {

            $this->hapusSatuFile(
                $field,
                $filename
            );
        }
    }

    /**
     * Menghapus file lama setelah file baru berhasil disimpan.
     */
    private function hapusFileLama(array $files): void
    {
        foreach ($files as $field => $filename) {

            $this->hapusSatuFile(
                $field,
                $filename
            );
        }
    }

    /**
     * Membatasi penghapusan hanya pada nama file
     * yang dibuat oleh mekanisme unggah dokumen P11.
     */
    private function hapusSatuFile(
        string $field,
        string $filename
    ): void {

        if (!in_array(
            $field,
            ['ft_ktp', 'ft_sim_a'],
            true
        )) {
            return;
        }

        $pola = '/^'
            . preg_quote($field, '/')
            . '_\d{14}_[a-f0-9]{16}\.(jpg|png|webp)$/';

        if (!preg_match($pola, $filename)) {
            return;
        }

        $path = dirname(APPPATH)
            . DIRECTORY_SEPARATOR . 'uploads'
            . DIRECTORY_SEPARATOR . 'penyewa'
            . DIRECTORY_SEPARATOR . $filename;

        if (is_file($path)) {
            @unlink($path);
        }
    }

    /**
     * Menyimpan flash message dan menerapkan
     * pola Post/Redirect/Get (PRG).
     */
    private function redirectDenganPesan(
        string $uri,
        string $jenis,
        string $pesan
    ): never {

        $_SESSION['flash_serah_terima'] = [
            'type' => $jenis,
            'message' => $pesan
        ];

        header('Location: ' . site_url($uri));

        exit;
    }
}
