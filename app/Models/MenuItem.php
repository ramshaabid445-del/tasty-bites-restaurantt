<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'discount_price',
        'tax_percent',
        'price',
        'image',
        'preparation_time',
        'type',
        'is_available',
        'is_featured',
        'stock_qty',
        'sort_order',
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

    public function scopeActive($query)
    {
        return $query->where(function ($query) {
            $query->where('status', 1)->orWhere('is_available', true);
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getCurrentPriceAttribute()
    {
        return $this->discount_price ?: $this->price;
    }

    public function getShortDescriptionAttribute()
    {
        return str($this->description)->stripTags()->limit(120);
    }

    // 4. Availability Helper (Blade mein use karne ke liye)
    public function getIsAvailableAttribute()
    {
        return (int) $this->status === 1;
    }
}
