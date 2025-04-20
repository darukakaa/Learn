<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKelompokLearning extends Model
{
    use HasFactory;

    protected $table = 'user_kelompok_learning';

    protected $fillable = [
        'user_id',
        'kelompok_id',
        'learning_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kelompok
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    // Relasi ke Learning
    public function learning()
    {
        return $this->belongsTo(Learning::class, 'learning_id');
    }
}
