<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = ['name', 'price', 'description', 'items', 'status'];

    // Yeh line lazmi dalein taake array sahi se save ho
    protected $casts = [
        'items' => 'array'
    ];
}