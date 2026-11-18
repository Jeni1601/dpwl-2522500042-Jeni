<?php
$username = $username ?? 'Admin';

require APPPATH . 'views/templates/header.php';
require APPPATH . 'views/templates/sidebar.php';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

$daftarPembayaran = is_array($daftarPembayaran ?? null)
    ? $daftarPembayaran
    : [];

$formatRupiah = static function ($nilai): string {
    return 'Rp ' . number_format((float) $nilai, 0, ',', '.');
};

$statusClass = static function (string $status): string {
    return match ($status) {
        'pending' => 'label-warning',
        'valid' => 'label-success',
        'invalid' => 'label-danger',
        default => 'label-default'
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

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Manajemen Pembayaran
            <small>Verifikasi pembayaran penyewa</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= $e(site_url('admin')) ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Manajemen Pembayaran</li>
        </ol>
    </section>

    <section class="content">

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= $e($error) ?>
            </div>
        <?php endif; ?>

        <div class="box box-success">

            <div class="box-header with-border">
                <h3 class="box-title">
                    Daftar Pembayaran Penyewa
                </h3>
            </div>

            <div class="box-body">

                <?php if ($daftarPembayaran === []): ?>

                    <div class="alert alert-info">
                        Belum terdapat data pembayaran.
                    </div>

                <?php else: ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped
                                      table-hover js-data-table">

                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Pembayaran</th>
                                    <th>Kode Sewa</th>
                                    <th>Nama Penyewa</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Jenis</th>
                                    <th>Nominal</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th class="no-sort">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach (
                                    $daftarPembayaran as $index => $item
                                ): ?>

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

                                    $namaPenyewa = (string) (
                                        $item['nm_lngkp']
                                        ?? $item['nama_penyewa']
                                        ?? $item['nm_penyewa']
                                        ?? $item['user_plg']
                                        ?? '-'
                                    );
                                    ?>

                                    <tr>
                                        <td><?= $index + 1 ?></td>

                                        <td>
                                            <?= $e($kodeBayar) ?>
                                        </td>

                                        <td>
                                            <?= $e(
                                                $item['kode_sewa'] ?? '-'
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= $e($namaPenyewa) ?>
                                        </td>

                                        <td>
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

                                        <td class="text-right">
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
                                            <span class="label <?= $e(
                                                $statusClass($status)
                                            ) ?>">
                                                <?= $e(
                                                    $labelStatus($status)
                                                ) ?>
                                            </span>
                                        </td>

                                       <td class="text-center">
    <a
        href="<?= $e(
            site_url(
                'admin/pembayaran/detail?kode_bayar='
                . rawurlencode($kodeBayar)
            )
        ) ?>"
        class="btn btn-xs btn-primary">
        <i class="fa fa-eye"></i>
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

    </section>
</div>

<?php require APPPATH . 'views/templates/footer.php'; ?>