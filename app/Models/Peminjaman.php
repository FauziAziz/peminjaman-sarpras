<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    protected $fillable = [
        'id_peminjam',
        'id_petugas',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status_peminjaman',
    ];

    // Tanggal dibaca sebagai objek tanggal agar bisa diformat, misalnya ->format('d-m-Y').
    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'id_peminjam', 'id_peminjam');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function detailPinjam()
    {
        return $this->hasMany(DetailPinjam::class, 'id_peminjaman', 'id_peminjaman');
    }
}
