<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
    ];

    // public function categories() {
    //     return $this->belongsTo(Category::class, 'category_id', 'id');   // referencia pertenece a
    // }

    // public function carts() {
    //     return $this->hasMany(Cart::class);  // referencia a
    // }
}