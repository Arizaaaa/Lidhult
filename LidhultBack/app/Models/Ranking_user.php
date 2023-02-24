<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ranking_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'puntuation',
    ];

    public function rankings(): BelongsTo {
        return $this->belongsTo(Ranking::class);   // referencia pertenece a
    }
}
