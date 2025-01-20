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
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->stage_id)) {
                $model->stage_id = 2; // Ganti 1 dengan nilai default yang diinginkan
            }
        });
    }
}
