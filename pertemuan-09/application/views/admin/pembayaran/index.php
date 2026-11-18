
<?php

$username = $username ?? 'Admin';

require APPPATH . 'views/templates/header.php';
require APPPATH . 'views/templates/sidebar.php';

// Mengamankan output HTML
$e = static function ($value): string {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};

// Memastikan daftar pembayaran berbentuk array
$daftarPembayaran = is_array($daftarPembayaran ?? null)
    ? $daftarPembayaran
    : [];

// Format nominal rupiah
$formatRupiah = static function ($nilai): string {
    return 'Rp ' . number_format(
        (float) $nilai,
        0,
        ',',
        '.'
    );
};

// Class badge status
$statusClass = static function (string $status): string {
    return match ($status) {
        'pending' => 'label-warning',
        'valid' => 'label-success',
        'invalid' => 'label-danger',
        default => 'label-default'
    };
};

// Label status pembayaran
$labelStatus = static function (
    string $status,
    bool $sudahUpload
): string {
    return match ($status) {
        'pending' => $sudahUpload
            ? 'Menunggu Verifikasi'
            : 'Menunggu Bukti Pembayaran',
        'valid' => 'Valid',
        'invalid' => 'Tidak Valid',
        default => ucfirst($status)
    };
};

?>

<div class="content-wrapper">

    <!-- Header halaman -->
    <section class="content-header">
        <h1>
            Manajemen Pembayaran
            <small>Verifikasi pembayaran penyewa</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= $e(site_url('admin')) ?>">
                    <i class="fa fa-dashboard"></i>
                    Dashboard
                </a>
            </li>

            <li class="active">
                Manajemen Pembayaran
            </li>
        </ol>
    </section>

    <!-- Konten utama -->
    <section class="content">

        <!-- Pesan error -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                <?= $e($error) ?>
            </div>
        <?php endif; ?>

        <div class="box box-success">

            <!-- Header box -->
            <div class="box-header with-border">

                <h3 class="box-title">
                    <i class="fa fa-money"></i>
                    Daftar Pembayaran Penyewa
                </h3>

                <div class="box-tools pull-right">
                    <span class="label label-info">
                        <?= count($daftarPembayaran) ?>
                        Pembayaran
                    </span>
                </div>

            </div>

            <!-- Isi box -->
            <div class="box-body">

                <?php if ($daftarPembayaran === []): ?>

                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        Belum terdapat data pembayaran.
                    </div>

                <?php else: ?>

                    <div class="table-responsive">

                        <table class="table table-bordered
                                      table-striped
                                      table-hover
                                      js-data-table">

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
                                    <th class="no-sort">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach (
                                    $daftarPembayaran
                                    as $index => $item
                                ): ?>

                                    <?php

                                    // Kode pembayaran
                                    $kodeBayar = (string) (
                                        $item['kode_bayar'] ?? ''
                                    );

                                    // Status pembayaran
                                    $status = (string) (
                                        $item['sttus_byr'] ?? ''
                                    );

                                    // Nama file bukti pembayaran
                                    $fotoBukti = (string) (
                                        $item['ft_byr'] ?? ''
                                    );

                                    // Memeriksa upload bukti
                                    $sudahUpload = trim(
                                        $fotoBukti
                                    ) !== '';

                                    // Jenis pembayaran
                                    $jenis = (string) (
                                        $item['jns_byr'] ?? ''
                                    );

                                    // Metode pembayaran
                                    $metode = (string) (
                                        $item['mtode_byr'] ?? ''
                                    );

                                    // Tanggal pembayaran
                                    $tanggal = (string) (
                                        $item['tgl_wkt_byr'] ?? ''
                                    );

                                    // Nama penyewa
                                    $namaPenyewa = (string) (
                                        $item['nm_lngkp']
                                        ?? $item['nama_penyewa']
                                        ?? $item['nm_penyewa']
                                        ?? $item['user_plg']
                                        ?? '-'
                                    );

                                    ?>

                                    <tr>

                                        <!-- Nomor -->
                                        <td>
                                            <?= $index + 1 ?>
                                        </td>

                                        <!-- Kode pembayaran -->
                                        <td>
                                            <?= $e($kodeBayar) ?>
                                        </td>

                                        <!-- Kode sewa -->
                                        <td>
                                            <?= $e(
                                                $item['kode_sewa']
                                                ?? '-'
                                            ) ?>
                                        </td>

                                        <!-- Nama penyewa -->
                                        <td>
                                            <?= $e($namaPenyewa) ?>
                                        </td>

                                        <!-- Tanggal pembayaran -->
                                        <td>
                                            <?php if (
                                                $tanggal !== ''
                                                && strtotime($tanggal)
                                                    !== false
                                            ): ?>

                                                <?= $e(
                                                    date(
                                                        'd-m-Y H:i',
                                                        strtotime($tanggal)
                                                    )
                                                ) ?>

                                            <?php else: ?>

                                                -

                                            <?php endif; ?>
                                        </td>

                                        <!-- Jenis pembayaran -->
                                        <td>
                                            <?php if (
                                                $jenis === 'dp'
                                            ): ?>

                                                DP

                                            <?php elseif (
                                                $jenis === 'pelunasan'
                                            ): ?>

                                                Pelunasan

                                            <?php else: ?>

                                                <?= $e(
                                                    ucfirst($jenis)
                                                ) ?>

                                            <?php endif; ?>
                                        </td>

                                        <!-- Nominal pembayaran -->
                                        <td class="text-right">
                                            <?= $e(
                                                $formatRupiah(
                                                    $item['nominal']
                                                    ?? 0
                                                )
                                            ) ?>
                                        </td>

                                        <!-- Metode pembayaran -->
                                        <td>
                                            <?php if (
                                                $metode === 'transfer'
                                            ): ?>

                                                Transfer

                                            <?php elseif (
                                                $metode === 'tunai'
                                            ): ?>

                                                Tunai

                                            <?php else: ?>

                                                <?= $e(
                                                    ucfirst($metode)
                                                ) ?>

                                            <?php endif; ?>
                                        </td>

                                        <!-- Status pembayaran -->
                                        <td>
                                            <span class="label <?= $e(
                                                $statusClass($status)
                                            ) ?>">

                                                <?= $e(
                                                    $labelStatus(
                                                        $status,
                                                        $sudahUpload
                                                    )
                                                ) ?>

                                            </span>
                                        </td>

                                        <!-- Tombol detail -->
                                        <td class="text-center">

                                            <a
                                                href="<?= $e(
                                                    site_url(
                                                        'admin/pembayaran/detail?kode_bayar='
                                                        . rawurlencode(
                                                            $kodeBayar
                                                        )
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

            <!-- Footer box -->
            <div class="box-footer">

                <small class="text-muted">
                    Menampilkan maksimal 3 pembayaran terbaru
                    dari seluruh penyewa.
                </small>

            </div>

        </div>

    </section>

</div>

<?php
require APPPATH . 'views/templates/footer.php';
?>
