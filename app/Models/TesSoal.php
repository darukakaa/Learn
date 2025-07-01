<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TesSoal extends Model
{
    protected $table = 'tes_soals';

    protected $fillable = [
        'nama_tes',
        'tanggal_tes',
    ];

    public function soals()
    {
        return $this->hasMany(Soal::class, 'tes_soals_id');
    }
}
