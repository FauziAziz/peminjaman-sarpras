<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = ['nama_kategori', 'kode_kategori', 'keterangan'];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'id_kategori', 'id_kategori');
    }
}
