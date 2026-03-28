<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // In columns ko mass assignment ke liye allow karein
    protected $fillable = [
        'key', 
        'value', 
        'group' // Agar aapne group rakha hai migration mein
    ];
}