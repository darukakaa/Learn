<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opsi extends Model
{
    protected $table = 'opsi';

    protected $fillable = [
        'soal_id',
        'opsi',
        'jawaban_teks',
        'is_correct',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
