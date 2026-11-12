<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    protected $table = 'peminjam';
    protected $primaryKey = 'id_peminjam';
    public $timestamps = false;

    protected $fillable = ['nama_peminjam', 'jabatan', 'aktif'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_peminjam', 'id_peminjam');
    }
}
