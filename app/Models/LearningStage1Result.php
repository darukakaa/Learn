<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningStage1Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_stage1_id',
        'user_id',
        'result',
    ];

    // Relasi dengan model LearningStage1
    public function learningStage1()
    {
        return $this->belongsTo(LearningStage1::class);
    }

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
