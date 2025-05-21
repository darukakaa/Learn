<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKelompok extends Model
{
    use HasFactory;

    protected $table = 'laporan_kelompok';

    protected $fillable = ['kelompok_id', 'uploaded_by', 'file_path', 'is_validated', 'user_id', 'learning_id'];


    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function learning()
    {
        return $this->belongsTo(Learning::class, 'learning_id');
    }
}
