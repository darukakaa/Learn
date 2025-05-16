<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanUser extends Model
{
    use HasFactory;

    protected $table = 'penugasan_users';

    protected $fillable = ['user_id', 'learning_id', 'kelompok_id', 'nama_penugasan', 'file'];

    public function user()
    {
        return $this->belongsTo(User::class);
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
