<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'menu_item_id', 'quantity', 'unit_price', 'addons', 'sub_total'
    ];

    protected $casts = [
        'addons' => 'array', // JSON ko array mein convert karne ke liye
    ];

    public function order() { return $this->belongsTo(Order::class); }
    public function menuItem() { return $this->belongsTo(MenuItem::class); }
    // app/Models/OrderItem.php mein ye add karein
    public function getPriceAttribute()
    {
    return $this->unit_price;
    }
}