<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Function fn_stok_tersedia
        DB::unprepared("
            CREATE FUNCTION fn_stok_tersedia(p_id_inventaris INT)
            RETURNS INT
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_total_pinjam INT DEFAULT 0;
                DECLARE v_jumlah_total INT DEFAULT 0;

                SELECT jumlah INTO v_jumlah_total FROM inventaris WHERE id_inventaris = p_id_inventaris;

                SELECT IFNULL(SUM(dp.jumlah), 0) INTO v_total_pinjam
                FROM detail_pinjam dp
                JOIN peminjaman p ON dp.id_peminjaman = p.id_peminjaman
                WHERE dp.id_inventaris = p_id_inventaris AND p.status_peminjaman = 'dipinjam';

                RETURN v_jumlah_total - v_total_pinjam;
            END
        ");

        // View v_stok_inventaris
        DB::unprepared("
            CREATE VIEW v_stok_inventaris AS
            SELECT 
                i.id_inventaris,
                i.kode_inventaris,
                i.nama,
                i.id_kategori,
                i.id_ruang,
                i.jumlah,
                IFNULL(SUM(CASE WHEN p.status_peminjaman = 'dipinjam' THEN dp.jumlah ELSE 0 END), 0) AS dipinjam,
                (i.jumlah - IFNULL(SUM(CASE WHEN p.status_peminjaman = 'dipinjam' THEN dp.jumlah ELSE 0 END), 0)) AS tersedia
            FROM inventaris i
            LEFT JOIN detail_pinjam dp ON i.id_inventaris = dp.id_inventaris
            LEFT JOIN peminjaman p ON dp.id_peminjaman = p.id_peminjaman
            GROUP BY i.id_inventaris, i.kode_inventaris, i.nama, i.id_kategori, i.id_ruang, i.jumlah
        ");

        // Procedure sp_buat_peminjaman
        DB::unprepared("
            CREATE PROCEDURE sp_buat_peminjaman(
                IN p_id_peminjam INT,
                IN p_id_petugas INT,
                IN p_tanggal_pinjam DATE
            )
            BEGIN
                DECLARE v_aktif TINYINT DEFAULT 0;

                SELECT aktif INTO v_aktif FROM peminjam WHERE id_peminjam = p_id_peminjam;
                IF v_aktif IS NULL OR v_aktif = 0 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Peminjam tidak ditemukan atau sudah tidak aktif.';
                END IF;

                INSERT INTO peminjaman (id_peminjam, id_petugas, tanggal_pinjam, status_peminjaman)
                VALUES (p_id_peminjam, p_id_petugas, p_tanggal_pinjam, 'dipinjam');

                SELECT LAST_INSERT_ID() AS id_peminjaman;
            END
        ");

        // Procedure sp_tambah_detail_pinjam
        DB::unprepared("
            CREATE PROCEDURE sp_tambah_detail_pinjam(
                IN p_id_peminjaman INT,
                IN p_id_inventaris INT,
                IN p_jumlah INT
            )
            BEGIN
                DECLARE v_status VARCHAR(20);
                DECLARE v_ada INT DEFAULT 0;
                DECLARE v_stok INT;

                SELECT status_peminjaman INTO v_status FROM peminjaman WHERE id_peminjaman = p_id_peminjaman;
                IF v_status IS NULL OR v_status != 'dipinjam' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Transaksi tidak ditemukan atau sudah dikembalikan.';
                END IF;

                IF p_jumlah < 1 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jumlah barang minimal 1.';
                END IF;

                SELECT COUNT(*) INTO v_ada FROM detail_pinjam WHERE id_peminjaman = p_id_peminjaman AND id_inventaris = p_id_inventaris;
                IF v_ada > 0 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Barang ini sudah ada di transaksi.';
                END IF;

                SELECT jumlah INTO v_stok FROM inventaris WHERE id_inventaris = p_id_inventaris FOR UPDATE;
                IF fn_stok_tersedia(p_id_inventaris) < p_jumlah THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok barang tidak mencukupi.';
                END IF;

                INSERT INTO detail_pinjam (id_peminjaman, id_inventaris, jumlah)
                VALUES (p_id_peminjaman, p_id_inventaris, p_jumlah);
            END
        ");

        // Procedure sp_kembalikan_peminjaman
        DB::unprepared("
            CREATE PROCEDURE sp_kembalikan_peminjaman(
                IN p_id_peminjaman INT,
                IN p_tanggal_kembali DATE
            )
            BEGIN
                DECLARE v_status VARCHAR(20);
                DECLARE v_tgl_pinjam DATE;

                SELECT status_peminjaman, tanggal_pinjam INTO v_status, v_tgl_pinjam 
                FROM peminjaman WHERE id_peminjaman = p_id_peminjaman;

                IF v_status IS NULL OR v_status != 'dipinjam' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Transaksi tidak ditemukan atau sudah dikembalikan.';
                END IF;

                IF p_tanggal_kembali < v_tgl_pinjam THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tanggal kembali tidak boleh sebelum tanggal pinjam.';
                END IF;

                UPDATE peminjaman 
                SET tanggal_kembali = p_tanggal_kembali, status_peminjaman = 'kembali' 
                WHERE id_peminjaman = p_id_peminjaman;
            END
        ");

        // Procedure sp_riwayat_peminjaman
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
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_riwayat_peminjaman");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_kembalikan_peminjaman");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_tambah_detail_pinjam");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_buat_peminjaman");
        DB::unprepared("DROP VIEW IF EXISTS v_stok_inventaris");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_stok_tersedia");
    }
};
