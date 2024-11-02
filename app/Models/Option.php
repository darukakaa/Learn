<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    // Add the necessary properties for mass assignment
    protected $fillable = ['question_id', 'option', 'is_correct'];

    /**
     * Get the question that owns the option.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}


