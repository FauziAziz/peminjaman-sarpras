<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

DB::unprepared('DROP PROCEDURE IF EXISTS sp_riwayat_peminjaman');
DB::unprepared("
    CREATE PROCEDURE sp_riwayat_peminjaman(
        IN p_dari DATE,
        IN p_sampai DATE,
        IN p_status VARCHAR(20),
        IN p_peminjam VARCHAR(255),
        IN p_id_kategori INT
    )
    BEGIN
        IF p_sampai < p_dari OR DATEDIFF(p_sampai, p_dari) > 365 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Rentang tanggal tidak valid (maksimal 1 tahun).';
        END IF;

        SELECT 
            p.id_peminjaman,
            p.tanggal_pinjam,
            pm.nama_peminjam,
            pm.jabatan,
            i.nama AS nama_barang,
            i.kondisi,
            dp.jumlah,
            p.status_peminjaman,
            p.tanggal_kembali,
            pt.nama_petugas
        FROM peminjaman p
        JOIN peminjam pm ON p.id_peminjam = pm.id_peminjam
        JOIN detail_pinjam dp ON p.id_peminjaman = dp.id_peminjaman
        JOIN inventaris i ON dp.id_inventaris = i.id_inventaris
        JOIN petugas pt ON p.id_petugas = pt.id_petugas
        WHERE 
            (
                (p_status = 'kembali' AND p.tanggal_kembali BETWEEN p_dari AND p_sampai)
                OR
                ((p_status IS NULL OR p_status = '' OR p_status = 'semua' OR p_status = 'dipinjam') AND p.tanggal_pinjam BETWEEN p_dari AND p_sampai)
            )
            AND (p_status IS NULL OR p_status = '' OR p_status = 'semua' OR p.status_peminjaman = p_status)
            AND (p_peminjam IS NULL OR p_peminjam = '' OR pm.nama_peminjam LIKE CONCAT('%', p_peminjam, '%'))
            AND (p_id_kategori IS NULL OR p_id_kategori = 0 OR i.id_kategori = p_id_kategori)
        ORDER BY p.id_peminjaman DESC, dp.id_detail_pinjam ASC;
    END
");
echo "Procedure sp_riwayat_peminjaman updated.\n";
