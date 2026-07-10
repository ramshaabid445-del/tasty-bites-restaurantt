<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Kaunse columns fill ho sakte hain
    protected $fillable = [
        'user_id', 
        'check_in', 
        'check_out', 
        'date', 
        'status'
    ];

    // Employee (User) ke saath talluq (Relationship)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}