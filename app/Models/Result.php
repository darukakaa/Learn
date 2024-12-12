<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'kuis_id', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kuis()
    {
        return $this->belongsTo(Kuisv2::class, 'kuis_id');
    }
}
