<?php

// app/Models/Evaluasi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;
    protected $table = 'evaluasi';
    protected $fillable = [
        'kelompok_id',
        'learning_id',
        'created_by',
        'deskripsi',
    ];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }

    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
