<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable
{
    use Notifiable;

    // Tentukan nama tabel jika Laravel tidak bisa menebaknya otomatis
    protected $table = 'mahasiswa';

    // Tentukan Primary Key custom
    protected $primaryKey = 'mahasiswa_id';

    // Daftar kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'username',
        'email',
        'password',
        'nama',
        'nim',
        'no_tlp',
        'program_studi',
        'kelas',
        'angkatan',
        'url_sosmed',
        'visual_path',
    ];

    // Sembunyikan password saat data dipanggil (misal: di-return sebagai JSON)
    protected $hidden = [
        'password',
    ];
    
    // Mutator untuk otomatis encrypt password jika belum di-hash di controller (Opsional tapi direkomendasikan)
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'mahasiswa_id', 'mahasiswa_id');
    }
}