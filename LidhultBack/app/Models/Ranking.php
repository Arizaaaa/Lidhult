<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id',
        'name',
        'code',
    ];

     public function ranking_users(): HasMany {
         return $this->hasMany(Ranking_users::class);  // referencia a
     }
}
