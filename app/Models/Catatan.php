<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;

    protected $table = 'catatan';

    protected $fillable = [
        'isi_catatan',
        'file_catatan',
        'learning_id',
        'kelompok_id',
        'user_id',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }
}
