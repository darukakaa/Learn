<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // Add the necessary properties for mass assignment
    protected $fillable = ['kuis_id', 'question'];

    /**
     * Get the kuis that owns the question.
     */
    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }

    /**
     * Get the options for the question.
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}



