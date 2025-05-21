<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $table = 'kelompok';

    protected $fillable = [
        'nama_kelompok',
        'jumlah_kelompok',
        'learning_id',
        'stage_id',
    ];

    // Definisikan relasi ke tabel Learning (one to many)
    public function learning()
    {
        return $this->belongsTo(Learning::class, 'learning_id');
    }

    public function anggota()
    {
        return $this->hasMany(UserKelompokLearning::class, 'kelompok_id');
    }

    public function penugasans()
    {
        return $this->hasMany(PenugasanUser::class);
    }
    public function catatan()
    {
        return $this->hasMany(Catatan::class, 'kelompok_id');
    }
    public function laporanKelompok()
    {
        return $this->hasMany(LaporanKelompok::class, 'kelompok_id');
    }






    // Mengatur nilai default untuk 'stage_id' saat membuat data
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->stage_id)) {
                $model->stage_id = 2; // Set default 'stage_id' ke 2 jika tidak ada
            }
        });
    }
}
