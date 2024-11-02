<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasFile extends Model
{
    use HasFactory;

    protected $fillable = ['tugas_id', 'user_id', 'file_path', 'uploaded_at'];
    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    // Relationship to Tugas
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
