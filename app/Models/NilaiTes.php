<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiTes extends Model
{
    protected $table = 'nilaites'; // Nama tabel di database

    protected $fillable = [
        'tes_soals_id',
        'user_id',
        'nilai',
    ];

    // Relasi ke TesSoal
    public function tesSoal()
    {
        return $this->belongsTo(TesSoal::class, 'tes_soals_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
