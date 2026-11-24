
<?php

require APPPATH . 'views/katalog/header.php';
require APPPATH . 'views/katalog/navbar.php';

// Data dari controller
$daftarPembayaran = $daftarPembayaran ?? [];
$flash = $flash ?? null;

// Escape HTML
$e = static function ($value): string {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};

?>

<section class="container py-5">

    <!-- JUDUL HALAMAN -->
    <div class="row mb-4">

        <div class="col">

            <h1 class="h2">Pembayaran Saya</h1>

            <p class="text-muted">
                Daftar pembayaran uang muka (DP)
                transaksi sewa kendaraan Anda.
            </p>

        </div>

    </div>


    <!-- NOTIFIKASI -->
    <?php if (is_array($flash) && !empty($flash['message'])): ?>

        <?php
        $jenisFlash = match ($flash['type'] ?? '') {
            'success' => 'success',
            'info' => 'info',
            default => 'danger'
        };
        ?>

        <div
            class="alert alert-<?= $e($jenisFlash) ?> alert-dismissible fade show"
            role="alert">

            <?= $e($flash['message']) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>

        </div>

    <?php endif; ?>


    <!-- DAFTAR PEMBAYARAN -->
    <div class="card shadow-sm">

        <div class="card-header">

            <h2 class="h5 mb-0">
                Daftar Pembayaran DP
            </h2>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>No.</th>
                            <th>Kode Pembayaran</th>
                            <th>Kode Sewa</th>
                            <th>Periode Sewa</th>
                            <th>Nominal DP</th>
                            <th>Status Pembayaran</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (empty($daftarPembayaran)): ?>

                            <tr>

                                <td colspan="8" class="text-center py-4">

                                    <p class="text-muted mb-0">
                                        Belum ada data pembayaran DP.
                                    </p>

                                </td>

                            </tr>

                        <?php else: ?>

                            <?php foreach ($daftarPembayaran as $i => $item): ?>

                                <?php

                                $status = strtolower(
                                    trim((string) ($item['sttus_byr'] ?? ''))
                                );

                                $labelStatus = [
                                    'pending' => 'Menunggu Verifikasi',
                                    'valid' => 'Valid',
                                    'invalid' => 'Ditolak'
                                ][$status] ?? ($status ?: '-');

                                $warnaStatus = [
                                    'pending' => 'warning',
                                    'valid' => 'success',
                                    'invalid' => 'danger'
                                ][$status] ?? 'secondary';

                                $kodeBayar = trim(
                                    (string) ($item['kode_bayar'] ?? '')
                                );

                                // Mengganti karakter / menjadi ~ untuk URL
                                $kodeBayarUrl = str_replace(
                                    '/',
                                    '~',
                                    $kodeBayar
                                );

                                $sudahUpload = !empty($item['ft_byr']);

                                ?>

                                <tr>

                                    <!-- NOMOR -->
                                    <td>
                                        <?= (int) $i + 1 ?>
                                    </td>


                                    <!-- KODE PEMBAYARAN -->
                                    <td>
                                        <?= $e($kodeBayar) ?>
                                    </td>


                                    <!-- KODE SEWA -->
                                    <td>
                                        <?= $e($item['kode_sewa'] ?? '-') ?>
                                    </td>


                                    <!-- PERIODE SEWA -->
                                    <td>
                                        <?= $e($item['tgl_mulai'] ?? '-') ?>
                                        s.d.
                                        <?= $e($item['tgl_selesai'] ?? '-') ?>
                                    </td>


                                    <!-- NOMINAL -->
                                    <td>
                                        <strong>
                                            Rp <?= number_format(
                                                (int) ($item['nominal'] ?? 0),
                                                0,
                                                ',',
                                                '.'
                                            ) ?>
                                        </strong>
                                    </td>


                                    <!-- STATUS -->
                                    <td>
                                        <span class="badge bg-<?= $e($warnaStatus) ?>">
                                            <?= $e($labelStatus) ?>
                                        </span>
                                    </td>


                                    <!-- BUKTI -->
                                    <td>

                                        <?php if ($sudahUpload): ?>

                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i>
                                                Sudah diunggah
                                            </span>

                                        <?php else: ?>

                                            <span class="text-danger">
                                                <i class="fas fa-times-circle"></i>
                                                Belum diunggah
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- AKSI -->
                                    <td>

                                        <?php if ($kodeBayar !== ''): ?>

                                            <a
                                                href="<?= $e(site_url(
                                                    'pembayaran/detail/' . $kodeBayarUrl
                                                )) ?>"
                                                class="btn btn-sm btn-outline-primary">

                                                <i class="fas fa-eye"></i>
                                                Detail

                                            </a>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Tidak tersedia
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- TOMBOL KEMBALI -->
    <div class="mt-4">

        <a
            href="<?= $e(site_url('katalog')) ?>"
            class="btn btn-success">

            <i class="fas fa-arrow-left"></i>
            Kembali ke Katalog

        </a>

    </div>

</section>

<?php
require APPPATH . 'views/katalog/footer.php';
?>
