<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
    ];


    protected $fillable = [
        'nama_tugas',
        'tanggal_dibuat',
    ];
    public function uploadedFiles()
    {
        return $this->hasMany(TugasFile::class)->orderBy('uploaded_at', 'desc');
    }

    public function hasValidatedFiles()
    {
        return $this->uploadedFiles()->where('is_validated', true)->exists();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
