<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $table = 'ruang';
    protected $primaryKey = 'id_ruang';
    public $timestamps = false;

    protected $fillable = ['nama_ruang', 'kode_ruang', 'keterangan'];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'id_ruang', 'id_ruang');
    }
}
