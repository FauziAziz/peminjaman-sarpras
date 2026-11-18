<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'inventaris';
    protected $primaryKey = 'id_inventaris';
    public $timestamps = false;

    protected $fillable = [
        'kode_inventaris',
        'nama',
        'id_kategori',
        'id_ruang',
        'jumlah',
        'kondisi',
        'keterangan',
        'tanggal_register',
        'id_petugas',
    ];

    // Tanggal dibaca sebagai objek tanggal agar bisa diformat, misalnya ->format('d-m-Y').
    protected function casts(): array
    {
        return ['tanggal_register' => 'date'];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'id_ruang', 'id_ruang');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}
