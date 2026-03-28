<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'permissions'];

    // Hum permissions array ko automatically JSON bana denge
    protected $casts = [
        'permissions' => 'array',
    ];

    public function permissions() {
    return $this->belongsToMany(Permission::class);
}
}