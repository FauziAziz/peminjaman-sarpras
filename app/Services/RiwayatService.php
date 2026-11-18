<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RiwayatService
{
    public function ambilRiwayat(string $dari, string $sampai, ?string $status, ?string $peminjam, ?int $idKategori): array
    {
        // Panggil stored procedure sp_riwayat_peminjaman
        // Parameter: p_dari, p_sampai, p_status, p_peminjam, p_id_kategori
        try {
            $results = DB::select('CALL sp_riwayat_peminjaman(?, ?, ?, ?, ?)', [
                $dari,
                $sampai,
                $status ?: 'semua',
                $peminjam ?: null,
                $idKategori ?: null,
            ]);

            return $results;
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'SQLSTATE[45000]')) {
                $parts = explode(':', $msg);
                $msg = trim(end($parts));
            }
            throw new \Exception($msg);
        }
    }
}
