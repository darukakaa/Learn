<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesSoal extends Model
{
    use HasFactory;

    protected $fillable = ['nama_tes', 'tanggal_tes'];
}
