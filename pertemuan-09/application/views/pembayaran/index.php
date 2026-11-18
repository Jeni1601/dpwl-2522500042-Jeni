<?php
require APPPATH . 'views/katalog/header.php';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

require APPPATH . 'views/katalog/navbar.php';

$formatRupiah = static function ($nilai): string {
    return 'Rp ' . number_format((float) $nilai, 0, ',', '.');
};

$daftarPembayaran = is_array($pembayaran ?? null)
    ? $pembayaran
    : [];

$flashType = is_array($flash ?? null)
    ? (string) ($flash['type'] ?? '')
    : '';

$flashMessage = is_array($flash ?? null)
    ? (string) ($flash['message'] ?? '')
    : (string) ($flash ?? '');

$flashClass = $flashType === 'success'
    ? 'alert-success'
    : 'alert-danger';

$statusClass = static function (string $status): string {
    return match ($status) {
        'pending' => 'bg-warning text-dark',
        'valid' => 'bg-success',
        'invalid' => 'bg-danger',
        default => 'bg-secondary'
    };
};

$labelStatus = static function (string $status): string {
    return match ($status) {
        'pending' => 'Menunggu Verifikasi',
        'valid' => 'Valid',
        'invalid' => 'Tidak Valid',
        default => ucfirst($status)
    };
};
?>

<section class="bg-success py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 text-white mt-3">
                    Pembayaran Saya
                </h1>

                <p class="text-white mb-0">
                    Lihat informasi pembayaran transaksi sewa kendaraan Anda.
                </p>
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a class="btn btn-danger"
                   href="<?= $e(site_url('katalog')) ?>">
                    <i class="fas fa-car me-1"></i>
                    Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <?php if ($flashMessage !== ''): ?>
            <div class="alert <?= $e($flashClass) ?> alert-dismissible fade show"
                 role="alert">
                <?= $e($flashMessage) ?>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $e($error) ?>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">
                    Daftar Pembayaran
                </h2>
            </div>

            <div class="card-body">

                <?php if ($daftarPembayaran === []): ?>

                    <div class="alert alert-info mb-0" role="status">
                        Belum ada data pembayaran.
                        Silakan lakukan transaksi sewa terlebih dahulu.
                    </div>

                <?php else: ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Kode Pembayaran</th>
                                    <th scope="col">Kode Sewa</th>
                                    <th scope="col">Tanggal Pembayaran</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col" class="text-end">
                                        Nominal
                                    </th>
                                    <th scope="col">Metode</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($daftarPembayaran as $item): ?>
                                    <?php
                                    $kodeBayar = (string) (
                                        $item['kode_bayar'] ?? ''
                                    );

                                    $status = (string) (
                                        $item['sttus_byr'] ?? ''
                                    );

                                    $jenis = (string) (
                                        $item['jns_byr'] ?? ''
                                    );

                                    $metode = (string) (
                                        $item['mtode_byr'] ?? ''
                                    );

                                    $tanggal = (string) (
                                        $item['tgl_wkt_byr'] ?? ''
                                    );
                                    ?>

                                    <tr>
                                        <td class="text-nowrap fw-semibold">
                                            <?= $e($kodeBayar) ?>
                                        </td>

                                        <td class="text-nowrap">
                                            <?= $e($item['kode_sewa'] ?? '') ?>
                                        </td>

                                        <td class="text-nowrap">
                                            <?= $e(
                                                $tanggal !== ''
                                                    ? date(
                                                        'd-m-Y H:i',
                                                        strtotime($tanggal)
                                                    )
                                                    : '-'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= $e(
                                                $jenis === 'dp'
                                                    ? 'DP'
                                                    : ($jenis === 'pelunasan'
                                                        ? 'Pelunasan'
                                                        : ucfirst($jenis))
                                            ) ?>
                                        </td>

                                        <td class="text-end text-nowrap fw-semibold">
                                            <?= $e(
                                                $formatRupiah(
                                                    $item['nominal'] ?? 0
                                                )
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= $e(
                                                $metode === 'transfer'
                                                    ? 'Transfer'
                                                    : ($metode === 'tunai'
                                                        ? 'Tunai'
                                                        : ucfirst($metode))
                                            ) ?>
                                        </td>

                                        <td>
                                            <span class="badge <?= $e(
                                                $statusClass($status)
                                            ) ?>">
                                                <?= $e(
                                                    $labelStatus($status)
                                                ) ?>
                                            </span>
                                        </td>

                                        <td class="text-center text-nowrap">
                                            <a class="btn btn-sm btn-outline-success"
                                               href="<?= $e(
                                                   site_url(
                                                       'pembayaran_controller/detail/'
                                                       . rawurlencode($kodeBayar)
                                                   )
                                               ) ?>">
                                                <i class="fas fa-eye me-1"
                                                   aria-hidden="true"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php endif; ?>

            </div>
        </div>

        <div class="alert alert-light border mt-4 mb-0">
            <i class="fas fa-info-circle text-success me-1"
               aria-hidden="true"></i>

            Status <strong>Menunggu Verifikasi</strong> berarti pembayaran
            belum diperiksa oleh Admin. Status akan berubah setelah Admin
            melakukan verifikasi.
        </div>

    </div>
</section>

<?php require APPPATH . 'views/katalog/footer.php'; ?>