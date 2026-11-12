<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PeminjamanService
{
    public function buatPeminjaman(int $idPeminjam, int $idPetugas, string $tanggalPinjam, array $items): int
    {
        return DB::transaction(function () use ($idPeminjam, $idPetugas, $tanggalPinjam, $items) {
            // 1. Panggil sp_buat_peminjaman
            $result = DB::select('CALL sp_buat_peminjaman(?, ?, ?)', [
                $idPeminjam,
                $idPetugas,
                $tanggalPinjam,
            ]);

            $idPeminjaman = $result[0]->id_peminjaman ?? null;

            if (!$idPeminjaman) {
                throw new \Exception('Gagal membuat ID peminjaman.');
            }

            // 2. Tambah detail pinjam per item
            $seenItems = [];
            foreach ($items as $item) {
                $idInventaris = $item['id_inventaris'];
                $jumlah = $item['jumlah'];

                if (in_array($idInventaris, $seenItems)) {
                    throw new \Exception('Barang yang sama tidak boleh dobel dalam satu transaksi.');
                }
                $seenItems[] = $idInventaris;

                DB::statement('CALL sp_tambah_detail_pinjam(?, ?, ?)', [
                    $idPeminjaman,
                    $idInventaris,
                    $jumlah,
                ]);
            }

            return $idPeminjaman;
        });
    }

    public function kembalikanPeminjaman(int $idPeminjaman, string $tanggalKembali): bool
    {
        return DB::transaction(function () use ($idPeminjaman, $tanggalKembali) {
            DB::statement('CALL sp_kembalikan_peminjaman(?, ?)', [
                $idPeminjaman,
                $tanggalKembali,
            ]);

            return true;
        });
    }
}
