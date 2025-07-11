<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiv2 extends Model
{
    use HasFactory;

    protected $table = 'materiv2';

    protected $fillable = [
        'nama_materi',
        'tanggal',
        'deskripsi',
        'tujuan',
        'capaian',
        'file_pdf',
        'link',
    ];

    protected $casts = [
        'link' => 'array',
    ];
}
