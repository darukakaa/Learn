<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    // Add the necessary properties for mass assignment
    protected $fillable = ['option', 'is_correct', 'question_id'];

    /**
     * Get the question that owns the option.
     */
    // Option.php
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
