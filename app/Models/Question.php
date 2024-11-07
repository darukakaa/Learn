<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // Add the necessary properties for mass assignment
    protected $fillable = ['question', 'kuis_id'];

    /**
     * Get the kuis that owns the question.
     */
    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
