<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuisv2 extends Model
{
    use HasFactory;

    protected $table = 'kuisv2';
    protected $fillable = ['nama_kuis', 'tanggal_kuis'];
    public function questions()
    {
        return $this->hasMany(QuestionV2::class, 'kuis_id');
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }
    public function questionsV2()
    {
        return $this->hasMany(QuestionV2::class, 'kuis_id');
    }
}
