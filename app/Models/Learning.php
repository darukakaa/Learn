<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    protected $table = 'learnings';

    public function learningStage1()
    {
        return $this->hasMany(LearningStage1::class, 'learning_id');
    }
}
