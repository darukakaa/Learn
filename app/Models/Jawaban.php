<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawaban';

    protected $fillable = [
        'user_id',
        'soal_id',
        'tes_soal_id',
        'pilihan_jawaban',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
