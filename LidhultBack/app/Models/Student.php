<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surnames',
        'email',
        'nick',
        'password',
        'character_id',
        'avatar',
        'total_puntuation',
        'birth_date',
    ];
}
