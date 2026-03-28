<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'status', // 1 = Active, 0 = Inactive
    ];

    // 1. Category Relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // 2. Orders Relationship (Through Pivot Table)
    // Yeh "Best Sellers" report ke liye zaroori hai
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'menu_item_id', 'order_id')
                    ->withPivot('quantity', 'sub_total')
                    ->withTimestamps();
    }

    // 3. Direct OrderItems Access
    // Agar humein direct quantity calculate karni ho
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'menu_item_id');
    }

    // 4. Availability Helper (Blade mein use karne ke liye)
    public function getIsAvailableAttribute()
    {
        return $this->status == 1;
    }
}