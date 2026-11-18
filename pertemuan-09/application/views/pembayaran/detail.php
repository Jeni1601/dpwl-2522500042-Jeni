<?php
require APPPATH . 'views/katalog/header.php';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

require APPPATH . 'views/katalog/navbar.php';

$formatRupiah = static function ($nilai): string {
    return 'Rp ' . number_format((float) $nilai, 0, ',', '.');
};

$kodeBayar = (string) ($pembayaran['kode_bayar'] ?? '');
$kodeSewa = (string) ($pembayaran['kode_sewa'] ?? '');
$status = (string) ($pembayaran['sttus_byr'] ?? '');
$jenis = (string) ($pembayaran['jns_byr'] ?? '');
$metode = (string) ($pembayaran['mtode_byr'] ?? '');
$fileBukti = (string) ($pembayaran['ft_byr'] ?? '');

$statusClass = match ($status) {
    'pending' => 'bg-warning text-dark',
    'valid' => 'bg-success',
    'invalid' => 'bg-danger',
    default => 'bg-secondary'
};

$labelStatus = match ($status) {
    'pending' => 'Menunggu Verifikasi',
    'valid' => 'Valid',
    'invalid' => 'Tidak Valid',
    default => ucfirst($status)
};

$bolehUpload = in_array($status, ['pending', 'invalid'], true)
    && $metode === 'transfer';
?>

<section class="bg-success py-4">
    <div class="container">
        <h1 class="h2 text-white mt-3">
            Detail Pembayaran
        </h1>

        <p class="text-white mb-0">
            Informasi lengkap pembayaran transaksi sewa kendaraan.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <div class="mb-4">
            <a href="<?= $e(site_url('pembayaran_controller')) ?>"
               class="btn btn-outline-success">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali ke Daftar Pembayaran
            </a>
        </div>

        <?php if (!empty($flash)): ?>
            <div class="alert alert-info" role="alert">
                <?= $e(is_array($flash)
                    ? ($flash['message'] ?? '')
                    : $flash) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $e($error) ?>
            </div>
        <?php endif; ?>

        <div class="row g-4">

            <!-- Informasi pembayaran -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white">
                        <h2 class="h5 mb-0">
                            Informasi Pembayaran
                        </h2>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th width="40%">Kode Pembayaran</th>
                                    <td><?= $e($kodeBayar) ?></td>
                                </tr>

                                <tr>
                                    <th>Kode Sewa</th>
                                    <td><?= $e($kodeSewa) ?></td>
                                </tr>

                                <tr>
                                    <th>Tanggal Pembayaran</th>
                                    <td>
                                        <?= $e(
                                            !empty($pembayaran['tgl_wkt_byr'])
                                                ? date(
                                                    'd-m-Y H:i',
                                                    strtotime(
                                                        $pembayaran['tgl_wkt_byr']
                                                    )
                                                )
                                                : '-'
                                        ) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Jenis Pembayaran</th>
                                    <td>
                                        <?= $e(
                                            $jenis === 'dp'
                                                ? 'Down Payment (DP)'
                                                : ($jenis === 'pelunasan'
                                                    ? 'Pelunasan'
                                                    : ucfirst($jenis))
                                        ) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Nominal</th>
                                    <td class="fw-bold text-success">
                                        <?= $e(
                                            $formatRupiah(
                                                $pembayaran['nominal'] ?? 0
                                            )
                                        ) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>
                                        <?= $e(
                                            $metode === 'transfer'
                                                ? 'Transfer'
                                                : ($metode === 'tunai'
                                                    ? 'Tunai'
                                                    : ucfirst($metode))
                                        ) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Status Pembayaran</th>
                                    <td>
                                        <span class="badge <?= $e($statusClass) ?>">
                                            <?= $e($labelStatus) ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Tanggal Verifikasi</th>
                                    <td>
                                        <?= $e(
                                            !empty($pembayaran['tgl_wkt_ver'])
                                                ? date(
                                                    'd-m-Y H:i',
                                                    strtotime(
                                                        $pembayaran['tgl_wkt_ver']
                                                    )
                                                )
                                                : 'Belum diverifikasi'
                                        ) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Status Sewa</th>
                                    <td>
                                        <?= $e(
                                            $pembayaran['status_sewa'] ?? '-'
                                        ) ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!-- Bukti pembayaran -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white">
                        <h2 class="h5 mb-0">
                            Bukti Pembayaran
                        </h2>
                    </div>

                    <div class="card-body">

                        <?php if ($fileBukti !== ''): ?>

                            <div class="mb-3">
                                <p class="text-muted">
                                    Bukti pembayaran yang telah diunggah:
                                </p>

                                <img
                                    src="<?= $e(
                                        site_url(
                                            'uploads/pembayaran/'
                                            . rawurlencode($fileBukti)
                                        )
                                    ) ?>"
                                    alt="Bukti pembayaran"
                                    class="img-fluid rounded border"
                                    style="max-height: 400px; width: 100%; object-fit: contain;"
                                >
                            </div>

                        <?php else: ?>

                            <div class="alert alert-warning">
                                Bukti pembayaran belum diunggah.
                            </div>

                        <?php endif; ?>

                        <?php if ($bolehUpload): ?>

                            <hr>

                            <h3 class="h6 mb-3">
                                <?= $status === 'invalid'
                                    ? 'Upload Ulang Bukti Pembayaran'
                                    : 'Upload Bukti Pembayaran' ?>
                            </h3>

                            <form
                                action="<?= $e(
                                    site_url(
                                        'pembayaran_controller/uploadBukti/'
                                        . rawurlencode($kodeBayar)
                                    )
                                ) ?>"
                                method="post"
                                enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label for="ft_byr"
                                           class="form-label">
                                        Pilih Foto Bukti Transfer
                                    </label>

                                    <input
                                        type="file"
                                        name="ft_byr"
                                        id="ft_byr"
                                        class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        required
                                    >

                                    <small class="text-muted">
                                        Format JPG, JPEG, PNG, atau WEBP.
                                        Maksimal 5 MB.
                                    </small>
                                </div>

                                <button type="submit"
                                        class="btn btn-success w-100">
                                    <i class="fas fa-upload me-1"></i>
                                    Upload Bukti Pembayaran
                                </button>

                            </form>

                        <?php elseif ($status === 'valid'): ?>

                            <div class="alert alert-success mb-0">
                                Pembayaran telah diverifikasi oleh Admin.
                            </div>

                        <?php elseif ($metode === 'tunai'): ?>

                            <div class="alert alert-info mb-0">
                                Pembayaran menggunakan metode tunai.
                                Bukti transfer tidak diperlukan.
                            </div>

                        <?php elseif ($status === 'pending' && $fileBukti !== ''): ?>

                            <div class="alert alert-info mb-0">
                                Bukti pembayaran sudah diunggah dan sedang
                                menunggu verifikasi Admin.
                            </div>

                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<?php require APPPATH . 'views/katalog/footer.php'; ?>