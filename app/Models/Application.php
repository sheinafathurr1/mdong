<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'application';
    protected $primaryKey = 'application_id';
    protected $fillable = ['mahasiswa_id', 'topik_id', 'tanggal_submit', 'tanggal_response', 'status'];

    public function topik()
    {
        return $this->belongsTo(TopikInterest::class, 'topik_id', 'topik_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'mahasiswa_id');
    }
}