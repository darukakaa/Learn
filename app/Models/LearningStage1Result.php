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
        'is_validated',
    ];

    // Relasi dengan model LearningStage1
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function learningStage1()
    {
        return $this->belongsTo(LearningStage1::class);
    }
}
