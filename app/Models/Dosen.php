<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Dosen extends Authenticatable
{
    use Notifiable;

    protected $table = 'dosen';
    protected $primaryKey = 'dosen_id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'nama',
        'kode',
        'nip',
        'no_tlp',
        'program_studi',
        'is_admin', // ENUM: 'YES', 'NO'
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}