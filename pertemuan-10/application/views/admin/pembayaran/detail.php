
<?php
$username = $username ?? 'Admin';

require APPPATH . 'views/templates/header.php';
require APPPATH . 'views/templates/sidebar.php';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

$item = is_array($pembayaran ?? null)
    ? $pembayaran
    : [];

$formatRupiah = static function ($nilai): string {
    return 'Rp ' . number_format((float) $nilai, 0, ',', '.');
};

$status = (string) ($item['sttus_byr'] ?? '');
$jenis = (string) ($item['jns_byr'] ?? '');
$metode = (string) ($item['mtode_byr'] ?? '');

$labelStatus = match ($status) {
    'pending' => 'Menunggu Verifikasi',
    'valid' => 'Valid',
    'invalid' => 'Tidak Valid',
    default => ucfirst($status)
};

$kodeBayar = (string) ($item['kode_bayar'] ?? '-');
$kodeSewa = (string) ($item['kode_sewa'] ?? '-');
$tanggalBayar = (string) ($item['tgl_wkt_byr'] ?? '');
$tanggalVerifikasi = (string) ($item['tgl_wkt_ver'] ?? '');
$namaBukti = trim((string) ($item['ft_byr'] ?? ''));
?>

<div class="content-wrapper" style="background:#ecf0f5;">

    <!-- Judul Halaman -->
    <section class="content-header">
        <h1>
            Detail Pembayaran
            <small>Informasi pembayaran penyewa</small>
        </h1>
    </section>

    <section class="content">

        <!-- ================================================== -->
        <!-- INFORMASI PEMBAYARAN                                -->
        <!-- ================================================== -->

        <div class="box box-primary"
             style="width:100%; box-sizing:border-box;">

            <div class="box-header with-border">
                <h3 class="box-title">Informasi Pembayaran</h3>
            </div>

            <div class="box-body" style="background:#ffffff;">

                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="35%">Kode Pembayaran</th>
                        <td><?= $e($kodeBayar) ?></td>
                    </tr>

                    <tr>
                        <th>Kode Sewa</th>
                        <td><?= $e($kodeSewa) ?></td>
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
                        <td>
                            <strong>
                                <?= $e(
                                    $formatRupiah(
                                        $item['nominal'] ?? 0
                                    )
                                ) ?>
                            </strong>
                        </td>
                    </tr>

                    <tr>
                        <th>Metode</th>
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
                        <th>Tanggal Pembayaran</th>
                        <td>
                            <?= $e(
                                $tanggalBayar !== ''
                                    ? date(
                                        'd-m-Y H:i',
                                        strtotime($tanggalBayar)
                                    )
                                    : '-'
                            ) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <?= $e($labelStatus) ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Tanggal Verifikasi</th>
                        <td>
                            <?= $e(
                                $tanggalVerifikasi !== ''
                                    ? date(
                                        'd-m-Y H:i',
                                        strtotime($tanggalVerifikasi)
                                    )
                                    : '-'
                            ) ?>
                        </td>
                    </tr>
                </table>

            </div>
        </div>


        <!-- ================================================== -->
        <!-- INFORMASI PENYEWA                                   -->
        <!-- ================================================== -->

        <div class="box box-info"
             style="width:100%; box-sizing:border-box;">

            <div class="box-header with-border">
                <h3 class="box-title">Informasi Penyewa</h3>
            </div>

            <div class="box-body" style="background:#ffffff;">

                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="35%">Username Penyewa</th>
                        <td><?= $e($item['user_plg'] ?? '-') ?></td>
                    </tr>

                    <tr>
                        <th>Nama Lengkap</th>
                        <td><?= $e($item['nm_lngkp'] ?? '-') ?></td>
                    </tr>

                    <tr>
                        <th>Nomor HP</th>
                        <td><?= $e($item['no_hp'] ?? '-') ?></td>
                    </tr>
                </table>

            </div>
        </div>


        <!-- ================================================== -->
        <!-- BUKTI PEMBAYARAN                                    -->
        <!-- ================================================== -->

        <div class="box box-success"
             style="width:100%; box-sizing:border-box;">

            <div class="box-header with-border">
                <h3 class="box-title">Bukti Pembayaran</h3>
            </div>

            <div class="box-body" style="background:#ffffff;">

                <?php if ($namaBukti !== ''): ?>

                    <p>
                        <strong>Nama File:</strong>
                        <?= $e($namaBukti) ?>
                    </p>

                    <img
                        src="<?= $e(
                            site_url(
                                'uploads/pembayaran/'
                                . rawurlencode($namaBukti)
                            )
                        ) ?>"
                        alt="Bukti Pembayaran"
                        class="img-responsive"
                        style="
                            width:auto;
                            max-width:100%;
                            max-height:600px;
                            border:1px solid #ddd;
                            padding:5px;
                            background:#fff;
                        "
                    >

                <?php else: ?>

                    <div class="alert alert-warning"
                         style="margin-bottom:0;">
                        <i class="fa fa-info-circle"></i>
                        Bukti pembayaran belum tersedia.
                    </div>

                <?php endif; ?>

            </div>
        </div>


        <!-- ================================================== -->
        <!-- VERIFIKASI PEMBAYARAN                               -->
        <!-- ================================================== -->

        <div class="box box-warning"
             style="
                width:100%;
                box-sizing:border-box;
                display:block;
                clear:both;
             ">

            <div class="box-header with-border">
                <h3 class="box-title">Verifikasi Pembayaran</h3>
            </div>

            <div class="box-body" style="background:#ffffff;">

                <?php if (!empty($flash)): ?>

                    <div class="alert alert-<?= $e($flash['type'] ?? 'info') ?>">
                        <?= $e($flash['message'] ?? '') ?>
                    </div>

                <?php endif; ?>


                <?php if ($status === 'pending'): ?>

                    <div class="alert alert-warning">
                        <i class="fa fa-clock-o"></i>
                        Pembayaran ini masih menunggu verifikasi Admin.
                    </div>

                    <form
                        method="post"
                        action="<?= $e(
                            site_url(
                                'admin/pembayaran/verifikasi?kode_bayar='
                                . rawurlencode($kodeBayar)
                            )
                        ) ?>"
                        style="
                            display:flex;
                            flex-wrap:wrap;
                            gap:10px;
                            align-items:center;
                        "
                    >

                        <button
                            type="submit"
                            name="status"
                            value="valid"
                            class="btn btn-success"
                            onclick="return confirm('Apakah Anda yakin menerima pembayaran ini?');"
                        >
                            <i class="fa fa-check"></i>
                            Terima Pembayaran
                        </button>

                        <button
                            type="submit"
                            name="status"
                            value="invalid"
                            class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin menolak pembayaran ini?');"
                        >
                            <i class="fa fa-times"></i>
                            Tolak Pembayaran
                        </button>

                    </form>


                <?php elseif ($status === 'valid'): ?>

                    <div class="alert alert-success"
                         style="margin-bottom:0;">

                        <i class="fa fa-check-circle"></i>
                        Pembayaran sudah dinyatakan valid.
                    </div>


                <?php elseif ($status === 'invalid'): ?>

                    <div class="alert alert-danger"
                         style="margin-bottom:0;">

                        <i class="fa fa-times-circle"></i>
                        Pembayaran dinyatakan tidak valid.
                    </div>


                <?php else: ?>

                    <div class="alert alert-info"
                         style="margin-bottom:0;">

                        Status pembayaran belum dapat diverifikasi.
                    </div>

                <?php endif; ?>

            </div>
        </div>


        <!-- ================================================== -->
        <!-- TOMBOL KEMBALI                                      -->
        <!-- ================================================== -->

        <div style="margin-bottom:20px;">

            <a
                href="<?= $e(site_url('admin/pembayaran')) ?>"
                class="btn btn-default"
            >
                <i class="fa fa-arrow-left"></i>
                Kembali ke Daftar Pembayaran
            </a>

        </div>

    </section>
</div>

<?php require APPPATH . 'views/templates/footer.php'; ?>
