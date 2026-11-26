
<?php
require APPPATH . 'views/katalog/header.php';

$e = static function ($value): string {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};

require APPPATH . 'views/katalog/navbar.php';

$formatRupiah = static function ($nilai): string {
    return 'Rp ' . number_format(
        (float) $nilai,
        0,
        ',',
        '.'
    );
};

// Mengambil detail kendaraan dalam keranjang.
$detail = is_array($keranjang['detail'] ?? null)
    ? $keranjang['detail']
    : [];

// Informasi notifikasi.
$flashType = (string) ($flash['type'] ?? '');
$flashMessage = (string) ($flash['message'] ?? '');

$flashClass = $flashType === 'success'
    ? 'alert-success'
    : 'alert-danger';

// Zona waktu Indonesia Barat.
$zonaWaktu = new DateTimeZone('Asia/Jakarta');

$sekarang = new DateTimeImmutable('now', $zonaWaktu);

// Waktu pengambilan minimal dua jam dari sekarang.
$minimumMulai = $sekarang->modify('+2 hours');

$minTanggalMulai = $minimumMulai->format('Y-m-d');

// Mengambil tanggal mulai yang tersimpan.
$tanggalMulaiAwal = (string) (
    $keranjang['tgl_mulai'] ?? $minTanggalMulai
);

// Memastikan tanggal mulai valid.
$tanggalMulaiObjek = DateTimeImmutable::createFromFormat(
    '!Y-m-d',
    $tanggalMulaiAwal,
    $zonaWaktu
);

if (
    !$tanggalMulaiObjek ||
    $tanggalMulaiObjek->format('Y-m-d') !== $tanggalMulaiAwal
) {
    $tanggalMulaiAwal = $minTanggalMulai;
    $tanggalMulaiObjek = DateTimeImmutable::createFromFormat(
        '!Y-m-d',
        $tanggalMulaiAwal,
        $zonaWaktu
    );
}

// Tanggal selesai minimal satu hari setelah tanggal mulai.
$minTanggalSelesai = $tanggalMulaiObjek
    ->modify('+1 day')
    ->format('Y-m-d');

// Mengambil waktu pengambilan yang tersimpan.
$waktuTersimpan = substr(
    (string) (
        $keranjang['wkt_ambil']
        ?? $minimumMulai->format('H:i:s')
    ),
    0,
    5
);
?>

<style>
    .keranjang-foto {
        width: 88px;
        height: 62px;
        object-fit: cover;
        border-radius: 5px;
    }

    .keranjang-foto-kosong {
        width: 88px;
        height: 62px;
        border-radius: 5px;
    }

    #wkt_ambil {
        cursor: pointer;
    }

    #batas-waktu-mulai {
        display: block;
        margin-top: 6px;
    }
</style>

<!-- Header halaman -->
<section class="bg-success py-4">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-8">
                <h1 class="h2 text-white mt-3">
                    Keranjang Sewa
                </h1>

                <p class="text-white mb-0">
                    Periksa kendaraan dan periode sewa sebelum
                    mengajukan transaksi.
                </p>
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a
                    class="btn btn-danger"
                    href="<?= $e(site_url('katalog')) ?>#katalog">

                    <i class="fas fa-car me-1"></i>
                    Lanjut Pilih Kendaraan

                </a>
            </div>

        </div>
    </div>
</section>

<!-- Isi keranjang -->
<section class="py-5">
    <div class="container">

        <!-- Notifikasi -->
        <?php if ($flashMessage !== ''): ?>

            <div
                class="alert <?= $e($flashClass) ?> alert-dismissible fade show"
                role="alert">

                <?= $e($flashMessage) ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup">
                </button>

            </div>

        <?php endif; ?>


        <!-- Informasi transaksi -->
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white">
                <h2 class="h5 mb-0">
                    Informasi Transaksi
                </h2>
            </div>

            <form
                method="post"
                action="<?= $e(site_url('transaksi/perbarui-periode')) ?>"
                id="form-periode-sewa">

                <input
                    type="hidden"
                    name="kode_sewa"
                    value="<?= $e($keranjang['kode_sewa'] ?? '') ?>">

                <div class="card-body">

                    <div class="row g-3">

                        <!-- Kode transaksi -->
                        <div class="col-md-6">

                            <div class="text-muted small">
                                Kode transaksi
                            </div>

                            <div class="fw-bold">
                                <?= $e($keranjang['kode_sewa'] ?? '') ?>
                            </div>

                        </div>

                        <!-- Status -->
                        <div class="col-md-6">

                            <div class="text-muted small">
                                Status
                            </div>

                            <span class="badge bg-secondary">
                                <?= $e($keranjang['status_sewa'] ?? 'keranjang') ?>
                            </span>

                        </div>

                        <!-- Tanggal mulai -->
                        <div class="col-md-4">

                            <label
                                for="tgl_mulai"
                                class="form-label">

                                Tanggal mulai

                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="tgl_mulai"
                                name="tgl_mulai"
                                min="<?= $e($minTanggalMulai) ?>"
                                value="<?= $e($tanggalMulaiAwal) ?>"
                                required>

                        </div>

                        <!-- Tanggal selesai -->
                        <div class="col-md-4">

                            <label
                                for="tgl_selesai"
                                class="form-label">

                                Tanggal selesai

                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="tgl_selesai"
                                name="tgl_selesai"
                                min="<?= $e($minTanggalSelesai) ?>"
                                value="<?= $e($keranjang['tgl_selesai'] ?? $minTanggalSelesai) ?>"
                                required>

                        </div>

                        <!-- Waktu pengambilan -->
                        <div class="col-md-4">

                            <label
                                for="wkt_ambil"
                                class="form-label">

                                Waktu pengambilan

                            </label>

                            <select
                                class="form-select"
                                id="wkt_ambil"
                                name="wkt_ambil"
                                data-current-value="<?= $e($waktuTersimpan) ?>"
                                required>

                                <option value="">
                                    Pilih waktu pengambilan
                                </option>

                            </select>

                            <small
                                class="text-muted"
                                id="batas-waktu-mulai">

                                Waktu pengambilan minimal dua jam
                                dari sekarang (WIB).

                            </small>

                        </div>

                    </div>

                    <!-- Tombol update -->
                    <div class="mt-3">

                        <button
                            type="submit"
                            class="btn btn-outline-success">

                            <i
                                class="fas fa-save me-1"
                                aria-hidden="true">
                            </i>

                            Update Keranjang

                        </button>

                    </div>

                </div>
            </form>
        </div>


        <!-- Daftar kendaraan -->
        <?php if ($detail === []): ?>

            <div class="alert alert-info" role="status">

                Keranjang masih kosong.
                Pilih kendaraan dari katalog untuk memulai transaksi.

            </div>

        <?php else: ?>

            <div class="table-responsive mb-4">

                <table class="table table-bordered table-hover align-middle bg-white">

                    <thead class="table-light">

                        <tr>
                            <th scope="col">Kendaraan</th>
                            <th scope="col">Nomor Polisi</th>
                            <th scope="col" class="text-end">
                                Harga per Hari
                            </th>
                            <th scope="col" class="text-center">
                                Durasi
                            </th>
                            <th scope="col" class="text-end">
                                Subtotal
                            </th>
                            <th scope="col" class="text-center">
                                Aksi
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($detail as $item): ?>

                            <?php
                            $harga = (int) ($item['hrg_sewa'] ?? 0);
                            $hari = (int) ($item['n_hari'] ?? 0);
                            $subtotal = $harga * $hari;

                            $foto = trim(
                                (string) ($item['ft_depan'] ?? '')
                            );
                            ?>

                            <tr>

                                <!-- Kendaraan -->
                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <?php if ($foto !== ''): ?>

                                            <img
                                                src="<?= $e(base_url('uploads/mobil/') . rawurlencode($foto)) ?>"
                                                alt="<?= $e($item['nm_mobil'] ?? 'Foto kendaraan') ?>"
                                                class="keranjang-foto"
                                                loading="lazy">

                                        <?php else: ?>

                                            <div
                                                class="bg-light border d-flex align-items-center justify-content-center keranjang-foto-kosong">

                                                <i
                                                    class="fas fa-car text-muted"
                                                    aria-hidden="true">
                                                </i>

                                            </div>

                                        <?php endif; ?>

                                        <span class="fw-semibold">
                                            <?= $e($item['nm_mobil'] ?? '') ?>
                                        </span>

                                    </div>

                                </td>

                                <!-- Nomor polisi -->
                                <td>
                                    <?= $e($item['no_plat'] ?? '') ?>
                                </td>

                                <!-- Harga per hari -->
                                <td class="text-end text-nowrap">

                                    <?= $e($formatRupiah($harga)) ?>

                                </td>

                                <!-- Durasi -->
                                <td class="text-center">

                                    <?= $e($hari) ?> hari

                                </td>

                                <!-- Subtotal -->
                                <td class="text-end text-nowrap fw-semibold">

                                    <?= $e($formatRupiah($subtotal)) ?>

                                </td>

                                <!-- Hapus kendaraan -->
                                <td class="text-center">

                                    <form
                                        method="post"
                                        action="<?= $e(site_url('transaksi/hapus')) ?>"
                                        onsubmit="return confirm('Hapus kendaraan ini dari keranjang?');">

                                        <input
                                            type="hidden"
                                            name="kode_sewa"
                                            value="<?= $e($keranjang['kode_sewa'] ?? '') ?>">

                                        <input
                                            type="hidden"
                                            name="no_plat"
                                            value="<?= $e($item['no_plat'] ?? '') ?>">

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger">

                                            <i
                                                class="fas fa-trash-alt me-1"
                                                aria-hidden="true">
                                            </i>

                                            Hapus

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                    <!-- Total -->
                    <tfoot>

                        <tr>

                            <th colspan="4" class="text-end">
                                Total Sewa
                            </th>

                            <th class="text-end text-nowrap">
                                <?= $e($formatRupiah($keranjang['total'] ?? 0)) ?>
                            </th>

                            <th></th>

                        </tr>

                    </tfoot>

                </table>

            </div>


            <!-- Checkout -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                <p class="mb-0 small">

                    Checkout mengajukan transaksi kepada admin.
                    Status kendaraan tidak berubah menjadi disewa
                    sampai transaksi disetujui admin.

                </p>

                <form
                    method="get"
                    action="<?= $e(site_url('transaksi/checkout')) ?>">

                    <input
                        type="hidden"
                        name="kode_sewa"
                        value="<?= $e($keranjang['kode_sewa'] ?? '') ?>">

                    <button
                        type="submit"
                        class="btn btn-success btn-lg">

                        <i
                            class="fas fa-arrow-right me-1"
                            aria-hidden="true">
                        </i>

                        Checkout / Lihat Konfirmasi

                    </button>

                </form>

            </div>

        <?php endif; ?>

    </div>
</section>


<!-- JavaScript pengaturan tanggal dan waktu -->
<script>
(() => {
    const tanggalMulai = document.getElementById('tgl_mulai');
    const tanggalSelesai = document.getElementById('tgl_selesai');
    const waktuAmbil = document.getElementById('wkt_ambil');

    const formPeriode = document.getElementById('form-periode-sewa');
    const labelBatas = document.getElementById('batas-waktu-mulai');

    if (
        !tanggalMulai ||
        !tanggalSelesai ||
        !waktuAmbil ||
        !formPeriode
    ) {
        console.error('Elemen form periode sewa tidak ditemukan.');
        return;
    }

    const pad = angka => String(angka).padStart(2, '0');

    // Mengambil tanggal dan waktu berdasarkan zona WIB.
    function bagianWIB(tanggal) {
        const formatter = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Jakarta',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            hourCycle: 'h23'
        });

        const bagian = formatter.formatToParts(tanggal);
        const hasil = {};

        bagian.forEach(item => {
            if (item.type !== 'literal') {
                hasil[item.type] = item.value;
            }
        });

        return {
            tanggal:
                `${hasil.year}-${hasil.month}-${hasil.day}`,

            jam: Number(hasil.hour),
            menit: Number(hasil.minute)
        };
    }

    // Menambah satu hari pada format YYYY-MM-DD.
    function tambahSatuHari(tanggal) {
        const bagian = tanggal.split('-').map(Number);

        const objekTanggal = new Date(
            Date.UTC(
                bagian[0],
                bagian[1] - 1,
                bagian[2]
            )
        );

        objekTanggal.setUTCDate(
            objekTanggal.getUTCDate() + 1
        );

        return [
            objekTanggal.getUTCFullYear(),
            pad(objekTanggal.getUTCMonth() + 1),
            pad(objekTanggal.getUTCDate())
        ].join('-');
    }

    function formatWaktu(jam, menit) {
        return `${pad(jam)}:${pad(menit)}`;
    }

    function hitungBatasWaktu() {
        // Waktu sekarang ditambah dua jam.
        const batas = new Date(
            Date.now() + (2 * 60 * 60 * 1000)
        );

        // Bulatkan ke menit berikutnya.
        if (
            batas.getSeconds() > 0 ||
            batas.getMilliseconds() > 0
        ) {
            batas.setMinutes(batas.getMinutes() + 1);
        }

        batas.setSeconds(0, 0);

        const informasiBatas = bagianWIB(batas);

        const tanggalBatas = informasiBatas.tanggal;

        // Tanggal mulai minimal dua jam dari sekarang.
        tanggalMulai.min = tanggalBatas;

        if (
            !tanggalMulai.value ||
            tanggalMulai.value < tanggalBatas
        ) {
            tanggalMulai.value = tanggalBatas;
        }

        // Tanggal selesai minimal satu hari setelah tanggal mulai.
        tanggalSelesai.min = tambahSatuHari(
            tanggalMulai.value
        );

        if (
            !tanggalSelesai.value ||
            tanggalSelesai.value < tanggalSelesai.min
        ) {
            tanggalSelesai.value = tanggalSelesai.min;
        }

        // Menentukan batas waktu pengambilan.
        let batasMenit = 0;

        if (tanggalMulai.value === tanggalBatas) {
            batasMenit =
                informasiBatas.jam * 60 +
                informasiBatas.menit;
        }

        // Mengingat pilihan waktu sebelumnya.
        const waktuSebelumnya =
            waktuAmbil.value ||
            waktuAmbil.dataset.currentValue ||
            '';

        // Menghapus pilihan waktu lama.
        waktuAmbil.replaceChildren();

        const placeholder = document.createElement('option');

        placeholder.value = '';
        placeholder.textContent = 'Pilih waktu pengambilan';

        waktuAmbil.appendChild(placeholder);

        // Membulatkan ke interval 15 menit berikutnya.
        const menitAwal =
            Math.ceil(batasMenit / 15) * 15;

        let pilihanLamaDitemukan = false;

        // Membuat daftar waktu dari pagi sampai malam.
        for (
            let menit = menitAwal;
            menit < 24 * 60;
            menit += 15
        ) {
            const jam = Math.floor(menit / 60);
            const sisaMenit = menit % 60;

            const nilai = formatWaktu(jam, sisaMenit);

            const opsi = document.createElement('option');

            opsi.value = nilai;
            opsi.textContent = nilai;

            if (nilai === waktuSebelumnya) {
                opsi.selected = true;
                pilihanLamaDitemukan = true;
            }

            waktuAmbil.appendChild(opsi);
        }

        // Jika waktu lama tidak tersedia,
        // pilih waktu paling awal yang tersedia.
        if (
            !pilihanLamaDitemukan &&
            waktuAmbil.options.length > 1
        ) {
            waktuAmbil.selectedIndex = 1;
        }

        // Simpan nilai pilihan sekarang.
        waktuAmbil.dataset.currentValue = waktuAmbil.value;

        // Informasi batas waktu.
        if (labelBatas) {
            let waktuPalingAwal = '00:00';

            if (tanggalMulai.value === tanggalBatas) {
                waktuPalingAwal = formatWaktu(
                    informasiBatas.jam,
                    informasiBatas.menit
                );
            }

            labelBatas.textContent =
                `Waktu paling awal: ${tanggalMulai.value} pukul ${waktuPalingAwal} WIB. Pilihan tersedia setiap 15 menit.`;
        }
    }

    // Ketika tanggal mulai diganti.
    tanggalMulai.addEventListener(
        'change',
        hitungBatasWaktu
    );

    // Ketika tanggal selesai diganti.
    tanggalSelesai.addEventListener('change', () => {
        if (
            tanggalSelesai.value < tanggalSelesai.min
        ) {
            tanggalSelesai.value = tanggalSelesai.min;
        }
    });

    // Ketika waktu pengambilan dipilih.
    waktuAmbil.addEventListener('change', () => {
        waktuAmbil.dataset.currentValue = waktuAmbil.value;
    });

    // Validasi sebelum form disimpan.
    formPeriode.addEventListener('submit', event => {
        const waktuDipilih = waktuAmbil.value;

        // Pastikan tanggal dan waktu terbaru.
        hitungBatasWaktu();

        if (
            tanggalSelesai.value <= tanggalMulai.value
        ) {
            event.preventDefault();

            alert(
                'Tanggal selesai harus setelah tanggal mulai.'
            );

            tanggalSelesai.focus();
            return;
        }

        // Pastikan waktu pilihan masih tersedia.
        if (
            !waktuDipilih ||
            waktuDipilih !== waktuAmbil.value
        ) {
            event.preventDefault();

            alert(
                'Silakan pilih waktu pengambilan yang tersedia.'
            );

            waktuAmbil.focus();
            return;
        }

        // Validasi dua jam untuk tanggal hari ini.
        const batas = new Date(
            Date.now() + (2 * 60 * 60 * 1000)
        );

        if (
            batas.getSeconds() > 0 ||
            batas.getMilliseconds() > 0
        ) {
            batas.setMinutes(batas.getMinutes() + 1);
        }

        batas.setSeconds(0, 0);

        const informasiBatas = bagianWIB(batas);

        if (tanggalMulai.value === informasiBatas.tanggal) {
            const waktuMinimum = formatWaktu(
                informasiBatas.jam,
                informasiBatas.menit
            );

            if (waktuAmbil.value < waktuMinimum) {
                event.preventDefault();

                alert(
                    'Waktu pengambilan harus minimal dua jam dari sekarang.'
                );

                waktuAmbil.focus();
            }
        }
    });

    // Jalankan saat halaman pertama kali dibuka.
    hitungBatasWaktu();

})();
</script>

<?php
require APPPATH . 'views/katalog/footer.php';
?>
