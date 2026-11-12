<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RiwayatService
{
    public function ambilRiwayat(string $dari, string $sampai, ?string $status = null, ?string $peminjam = null, ?int $idKategori = null)
    {
        return DB::select('CALL sp_riwayat_peminjaman(?, ?, ?, ?, ?)', [
            $dari,
            $sampai,
            $status,
            $peminjam,
            $idKategori
        ]);
    }
}
