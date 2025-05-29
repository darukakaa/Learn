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
    public function uploadedFiles()
    {
        return $this->hasMany(TugasFile::class)->latest('uploaded_at');
    }

    // Cek apakah tugas ini punya minimal satu file tervalidasi
    public function hasValidatedFiles()
    {
        return $this->uploadedFiles()->where('is_validated', true)->exists();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
