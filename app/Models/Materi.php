<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    // Only include fields that exist in your database
    protected $fillable = [
        'nama_materi',
        'file_ppt',
        'file_pdf',
    ];
}