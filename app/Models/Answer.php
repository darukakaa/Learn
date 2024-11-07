<?php

// app/Models/Answer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = [
        'question_id',
        'user_id',
        'answer_text', // or 'answer_id' if you are storing answer IDs
    ];

    /**
     * Get the question that this answer belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
