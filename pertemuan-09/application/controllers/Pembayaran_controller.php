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

            $this->view('pembayaran/detail', [
                'pembayaran' => $detail,
                'error' => null
            ]);
        } catch (Throwable $e) {
            error_log(
                'Detail pembayaran penyewa gagal: ' . $e->getMessage()
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
}