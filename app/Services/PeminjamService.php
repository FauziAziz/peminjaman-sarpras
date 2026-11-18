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

    public function hapus(Peminjam $peminjam): bool
    {
        if ($peminjam->peminjaman()->count() > 0) {
            throw new \Exception('Peminjam tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
        }

        return $peminjam->delete();
    }
}
