<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    public function petugas()
    {
        return $this->hasMany(Petugas::class, 'id_level', 'id_level');
    }
}
