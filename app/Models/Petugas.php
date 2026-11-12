<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    use Notifiable;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'username',
        'password',
        'nama_petugas',
        'id_level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }

    public function isAdmin(): bool
    {
        return optional($this->level)->nama_level === 'admin';
    }

    public function isOperator(): bool
    {
        return optional($this->level)->nama_level === 'operator';
    }
}
