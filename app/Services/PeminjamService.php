<?php

namespace App\Services;

use App\Models\Peminjam;

class PeminjamService
{
    public function simpan(array $data): Peminjam
    {
        $data['aktif'] = $data['aktif'] ?? 1;
        return Peminjam::create($data);
    }

    public function perbarui(Peminjam $peminjam, array $data): bool
    {
        return $peminjam->update($data);
    }

    public function toggleAktif(Peminjam $peminjam): bool
    {
        $peminjam->aktif = !$peminjam->aktif;
        return $peminjam->save();
    }
}
