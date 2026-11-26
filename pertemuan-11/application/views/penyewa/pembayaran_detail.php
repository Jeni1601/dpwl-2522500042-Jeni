
<?php

require APPPATH . 'views/katalog/header.php';
require APPPATH . 'views/katalog/navbar.php';

// Data dari controller
$pembayaran = $pembayaran ?? [];
$daftarKendaraan = $daftarKendaraan ?? [];
$flash = $flash ?? null;

// Escape HTML
$e = static function ($value): string {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};

// Informasi pembayaran
$kodeBayar = trim(
    (string) ($pembayaran['kode_bayar'] ?? '')
);

$status = strtolower(
    trim((string) ($pembayaran['sttus_byr'] ?? ''))
);

$namaBukti = trim(
    (string) ($pembayaran['ft_byr'] ?? '')
);

// Pembayaran hanya bisa diunggah ketika masih pending
$bolehUnggah = (
    $status === 'pending'
    && empty($pembayaran['tgl_wkt_ver'])
);

// Kode pembayaran untuk URL
$kodeBayarUrl = str_replace('/', '~', $kodeBayar);

?>

<section class="container py-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h1 class="h2 mb-1">Detail Pembayaran DP</h1>
            <p class="text-muted mb-0">
                Informasi lengkap pembayaran transaksi sewa kendaraan.
            </p>
        </div>

        <a
            href="<?= $e(site_url('pembayaran')) ?>"
            class="btn btn-outline-secondary mt-2">
            Kembali
        </a>
    </div>


    <!-- PESAN NOTIFIKASI -->
    <?php if (is_array($flash) && !empty($flash['message'])): ?>

        <?php
        $jenisFlash = ($flash['type'] ?? '') === 'success'
            ? 'success'
            : (
                ($flash['type'] ?? '') === 'info'
                    ? 'info'
                    : 'danger'
            );
        ?>

        <div class="alert alert-<?= $e($jenisFlash) ?> alert-dismissible fade show"
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


    <!-- INFORMASI PEMBAYARAN -->
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h2 class="h5 mb-0">Informasi Pembayaran</h2>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered mb-0">

                    <tbody>

                        <tr>
                            <th width="35%">Kode Pembayaran</th>
                            <td><?= $e($kodeBayar) ?></td>
                        </tr>

                        <tr>
                            <th>Kode Transaksi Sewa</th>
                            <td>
                                <?= $e($pembayaran['kode_sewa'] ?? '') ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Periode Sewa</th>
                            <td>
                                <?= $e($pembayaran['tgl_mulai'] ?? '-') ?>
                                s.d.
                                <?= $e($pembayaran['tgl_selesai'] ?? '-') ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Waktu Rencana Pengambilan</th>
                            <td>
                                <?= $e($pembayaran['wkt_ambil'] ?? '-') ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Nominal DP</th>
                            <td>
                                <strong>
                                    Rp <?= number_format(
                                        (int) ($pembayaran['nominal'] ?? 0),
                                        0,
                                        ',',
                                        '.'
                                    ) ?>
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>
                                <?= $e($pembayaran['mtode_byr'] ?? '-') ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Status Pembayaran</th>
                            <td>
                                <?php if ($status === 'pending'): ?>
                                    <span class="badge bg-warning text-dark">
                                        Menunggu Verifikasi
                                    </span>
                                <?php elseif ($status === 'valid'): ?>
                                    <span class="badge bg-success">
                                        Valid
                                    </span>
                                <?php elseif ($status === 'invalid'): ?>
                                    <span class="badge bg-danger">
                                        Tidak Valid
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">
                                        <?= $e($status ?: '-') ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Status Transaksi</th>
                            <td>
                                <?= $e($pembayaran['status_sewa'] ?? '-') ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Waktu Unggah</th>
                            <td>
                                <?= $e($pembayaran['tgl_wkt_byr'] ?? '-') ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Waktu Verifikasi</th>
                            <td>
                                <?= $e($pembayaran['tgl_wkt_ver'] ?? '-') ?>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- DAFTAR KENDARAAN -->
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h2 class="h5 mb-0">Kendaraan yang Dipesan</h2>
        </div>

        <div class="card-body">

            <?php if (empty($daftarKendaraan)): ?>

                <div class="alert alert-warning mb-0">
                    Data kendaraan pada transaksi ini tidak ditemukan.
                </div>

            <?php else: ?>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped mb-0">

                        <thead class="table-light">
                            <tr>
                                <th width="8%">No.</th>
                                <th>No. Polisi</th>
                                <th>Nama Kendaraan</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($daftarKendaraan as $i => $kendaraan): ?>

                                <tr>
                                    <td><?= (int) $i + 1 ?></td>

                                    <td>
                                        <?= $e($kendaraan['no_plat'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= $e($kendaraan['nm_mobil'] ?? '-') ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </div>

    </div>


    <!-- BUKTI TRANSFER -->
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h2 class="h5 mb-0">Bukti Transfer</h2>
        </div>

        <div class="card-body">

            <?php if ($namaBukti !== ''): ?>

                <div class="text-center">

                    <img
                        src="<?= $e(base_url(
                            'uploads/bayar/' . rawurlencode($namaBukti)
                        )) ?>"
                        alt="Bukti transfer pembayaran"
                        class="img-fluid img-thumbnail"
                        style="max-width: 520px;">

                    <p class="text-muted mt-2 mb-0">
                        Bukti pembayaran yang telah diunggah.
                    </p>

                </div>

            <?php else: ?>

                <div class="alert alert-warning mb-0">
                    Bukti pembayaran belum diunggah.
                </div>

            <?php endif; ?>

        </div>

    </div>


    <!-- FORM UPLOAD BUKTI PEMBAYARAN -->
    <?php if ($bolehUnggah && $kodeBayar !== ''): ?>

        <div class="card shadow-sm mb-4">

            <div class="card-header">
                <h2 class="h5 mb-0">
                    Unggah atau Ganti Bukti Transfer
                </h2>
            </div>

            <div class="card-body">

                <p class="text-muted">
                    Silakan unggah foto bukti transfer dengan format
                    JPEG, PNG, atau WEBP. Ukuran maksimal 5 MB.
                </p>

                <form
                    action="<?= $e(site_url(
                        'pembayaran/upload-bukti/' . $kodeBayarUrl
                    )) ?>"
                    method="post"
                    enctype="multipart/form-data">

                    <div class="mb-3">

                        <label
                            for="ft_byr"
                            class="form-label">
                            Pilih Foto Bukti Pembayaran
                        </label>

                        <input
                            type="file"
                            name="ft_byr"
                            id="ft_byr"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            required>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-success">

                        <i class="fas fa-upload"></i>
                        Unggah Bukti Pembayaran

                    </button>

                </form>

            </div>

        </div>

    <?php elseif ($status !== 'pending'): ?>

        <div class="alert alert-info">
            Pembayaran telah diproses dan tidak dapat diubah.
        </div>

    <?php elseif ($kodeBayar === ''): ?>

        <div class="alert alert-danger">
            Kode pembayaran tidak ditemukan.
        </div>

    <?php endif; ?>


    <!-- TOMBOL KEMBALI -->
    <a
        href="<?= $e(site_url('pembayaran')) ?>"
        class="btn btn-outline-secondary">

        <i class="fas fa-arrow-left"></i>
        Kembali ke Daftar Pembayaran

    </a>

</section>

<?php
require APPPATH . 'views/katalog/footer.php';
?>
