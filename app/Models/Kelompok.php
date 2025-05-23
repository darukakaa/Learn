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
        'terisi', // agar bisa diisi mass assignment
    ];

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

    // Hitung jumlah anggota langsung dari database
    public function countAnggota()
    {
        return UserKelompokLearning::where('kelompok_id', $this->id)->count();
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->stage_id)) {
                $model->stage_id = 2;
            }

            // Set default terisi 0 kalau belum ada nilainya
            if (is_null($model->terisi)) {
                $model->terisi = 0;
            }
        });
    }
}
