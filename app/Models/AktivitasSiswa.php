<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasSiswa extends Model
{
    protected $table = 'aktivitas_siswa';


    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'learning_id',
        'tahap',
        'jenis_aktivitas',
        'deskripsi',
        'waktu_aktivitas',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }
}
