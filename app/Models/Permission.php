<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Boot function to automatically create slug from name
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($permission) {
            if (empty($permission->slug)) {
                $permission->slug = Str::slug($permission->name, '_');
            }
        });
    }

    /**
     * Relationship with Roles (Many-to-Many)
     * Agar aapne pivot table banayi hai toh ye kaam karega
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}