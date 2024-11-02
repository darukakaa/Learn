<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    // Add the necessary properties for mass assignment
    protected $fillable = ['nama_kuis', 'tanggal_ditambahkan'];

    /**
     * Get the questions for the kuis.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}


