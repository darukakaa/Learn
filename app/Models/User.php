<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function answers()
    {
        return $this->hasMany(AnswerV2::class);
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    public function penugasans()
    {
        return $this->hasMany(PenugasanUser::class);
    }
    public function kelompokBelajar()
    {
        return $this->belongsToMany(Kelompok::class, 'user_kelompok_learning', 'user_id', 'kelompok_id')
            ->withPivot('learning_id')
            ->withTimestamps();
    }
    public function isAdmin()
    {
        return $this->role === 0;
    }

    public function isGuru()
    {
        return $this->role === 1;
    }
}
