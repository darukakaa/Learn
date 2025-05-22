<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefleksiUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'learning_id',
        'apa_yang_dipelahari',
        'kesulitan',
        'kontribusi',
        'saran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }
}
