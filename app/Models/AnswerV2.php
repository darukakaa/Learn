<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerV2 extends Model
{
    use HasFactory;

    protected $table = 'answers_v2';

    protected $fillable = [
        'user_id',
        'question_id',
        'selected_answer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(QuestionV2::class);
    }
}
