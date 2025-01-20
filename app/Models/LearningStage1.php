<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningStage1 extends Model
{
    use HasFactory;

    protected $table = 'learning_stage1';

    protected $fillable = ['learning_id', 'problem', 'file'];


    // Relasi ke Learning

    public function learning()
    {
        return $this->belongsTo(Learning::class, 'learning_id');
    }

    public function learningStage1Results()
    {
        return $this->hasMany(LearningStage1Result::class);
    }
}
