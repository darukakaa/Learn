<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';

    protected $fillable = [
        'tes_soals_id',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'pilihan_e',
        'jawaban_benar',
        'gambar',
        'bobot_nilai',
    ];

    // Relasi jika kamu punya model TesSoal
    public function tesSoal()
    {
        return $this->belongsTo(TesSoal::class, 'tes_soals_id');
    }
    // Soal memiliki banyak jawaban dari user
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'soal_id');
    }
    public function opsi()
    {
        return $this->hasMany(Opsi::class, 'soal_id');
    }
}
