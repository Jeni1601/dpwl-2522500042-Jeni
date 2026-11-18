<?php

class Pembayaran_model
{
    private mysqli $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    // P9: Mengambil seluruh pembayaran milik penyewa
    public function getByPenyewa(string $userPlg): array
    {
        $sql = "SELECT
                    b.kode_bayar,
                    b.tgl_wkt_byr,
                    b.ft_byr,
                    b.mtode_byr,
                    b.jns_byr,
                    b.nominal,
                    b.sttus_byr,
                    b.tgl_wkt_ver,
                    b.kode_sewa,
                    s.tgl_mulai,
                    s.tgl_selesai,
                    s.wkt_ambil,
                    s.status_sewa
                FROM t_bayar b
                JOIN t_sewa s
                    ON b.kode_sewa = s.kode_sewa
                WHERE s.user_plg = ?
                ORDER BY b.tgl_wkt_byr DESC";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Query pembayaran penyewa gagal disiapkan.'
            );
        }

        $stmt->bind_param('s', $userPlg);

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Pengambilan pembayaran penyewa gagal.'
            );
        }

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $data;
    }

    // P9: Mengambil detail pembayaran milik penyewa
    public function getDetailPenyewa(
        string $kodeBayar,
        string $userPlg
    ): ?array {
        $sql = "SELECT
                    b.kode_bayar,
                    b.tgl_wkt_byr,
                    b.ft_byr,
                    b.mtode_byr,
                    b.jns_byr,
                    b.nominal,
                    b.sttus_byr,
                    b.tgl_wkt_ver,
                    b.kode_sewa,
                    s.tgl_mulai,
                    s.tgl_selesai,
                    s.wkt_ambil,
                    s.status_sewa
                FROM t_bayar b
                JOIN t_sewa s
                    ON b.kode_sewa = s.kode_sewa
                WHERE b.kode_bayar = ?
                    AND s.user_plg = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Query detail pembayaran gagal disiapkan.'
            );
        }

        $stmt->bind_param(
            'ss',
            $kodeBayar,
            $userPlg
        );

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Pengambilan detail pembayaran gagal.'
            );
        }

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ?: null;
    }

    // P9: Menyimpan bukti pembayaran yang diunggah penyewa
    public function updateBukti(
        string $kodeBayar,
        string $userPlg,
        string $fileBukti
    ): bool {
        $sql = "UPDATE t_bayar
                SET ft_byr = ?,
                    sttus_byr = 'pending',
                    tgl_wkt_ver = NULL
                WHERE kode_bayar = ?
                    AND sttus_byr IN ('pending', 'invalid')
                    AND EXISTS (
                        SELECT 1
                        FROM t_sewa
                        WHERE t_sewa.kode_sewa = t_bayar.kode_sewa
                            AND t_sewa.user_plg = ?
                    )";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Query upload bukti pembayaran gagal disiapkan.'
            );
        }

        $stmt->bind_param(
            'sss',
            $fileBukti,
            $kodeBayar,
            $userPlg
        );

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // P9: Mengambil seluruh data pembayaran untuk Admin
    public function getAll(): array
    {
        $sql = "SELECT
                    b.kode_bayar,
                    b.tgl_wkt_byr,
                    b.ft_byr,
                    b.mtode_byr,
                    b.jns_byr,
                    b.nominal,
                    b.sttus_byr,
                    b.tgl_wkt_ver,
                    b.kode_sewa,
                    s.user_plg,
                    s.tgl_mulai,
                    s.tgl_selesai,
                    s.status_sewa,
                    p.nm_lngkp
                FROM t_bayar b
                JOIN t_sewa s
                    ON b.kode_sewa = s.kode_sewa
                LEFT JOIN t_penyewa p
                    ON s.user_plg = p.user_plg
                ORDER BY b.tgl_wkt_byr DESC";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Query daftar pembayaran Admin gagal disiapkan.'
            );
        }

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Pengambilan daftar pembayaran Admin gagal.'
            );
        }

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $data;
    }

    // P9: Mengambil detail pembayaran untuk Admin
    public function getDetailAdmin(string $kodeBayar): ?array
    {
        $sql = "SELECT
                    b.kode_bayar,
                    b.tgl_wkt_byr,
                    b.ft_byr,
                    b.mtode_byr,
                    b.jns_byr,
                    b.nominal,
                    b.sttus_byr,
                    b.tgl_wkt_ver,
                    b.kode_sewa,
                    s.user_plg,
                    s.tgl_mulai,
                    s.tgl_selesai,
                    s.wkt_ambil,
                    s.status_sewa,
                    p.nm_lngkp,
                    p.no_hp
                FROM t_bayar b
                JOIN t_sewa s
                    ON b.kode_sewa = s.kode_sewa
                LEFT JOIN t_penyewa p
                    ON s.user_plg = p.user_plg
                WHERE b.kode_bayar = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Query detail verifikasi pembayaran gagal disiapkan.'
            );
        }

        $stmt->bind_param('s', $kodeBayar);

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Pengambilan detail verifikasi pembayaran gagal.'
            );
        }

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ?: null;
    }

    // P9: Verifikasi pembayaran oleh Admin
   public function verifikasi(
    string $kodeBayar,
    string $status
): bool {
    if (!in_array($status, ['valid', 'invalid'], true)) {
        return false;
    }

    $sql = "UPDATE t_bayar
            SET sttus_byr = ?,
                tgl_wkt_ver = NOW()
            WHERE kode_bayar = ?
                AND sttus_byr = 'pending'";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
        throw new RuntimeException(
            'Query verifikasi pembayaran gagal disiapkan.'
        );
    }

    $stmt->bind_param(
        'ss',
        $status,
        $kodeBayar
    );

    $success = $stmt->execute();

    // Pastikan benar-benar ada satu data yang diperbarui.
    $affectedRows = $stmt->affected_rows;

    $stmt->close();

    return $success && $affectedRows === 1;
}
}