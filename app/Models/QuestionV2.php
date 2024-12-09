<?php

namespace App\Models;

use App\Models\Kuisv2;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionV2 extends Model
{
    use HasFactory;
    protected $table = 'questionsv2';

    protected $fillable = [
        'kuis_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
        'correct_answer',
        'image',
    ];

    // Define the relationship between a question and its quiz
    public function kuis()
    {
        return $this->belongsTo(Kuisv2::class, 'kuis_id');
    }
    public function answers()
    {
        return $this->hasMany(AnswerV2::class);
    }
}
