<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'status', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where(function ($query) {
            $query->where('status', 1)->orWhere('is_active', true);
        });
    }
}
