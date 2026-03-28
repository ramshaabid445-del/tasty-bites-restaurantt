<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'dining_table_id', 'customer_name', 'customer_phone',
        'order_type', 'status', 'sub_total', 'tax_amount', 'discount_amount',  'total_amount',
        'payment_method', 'payment_status', 'notes'
    ];

    /**
     * Relationship Fix: 
     * Aapke Controller mein 'table' call ho raha hai, isliye humne function ka naam 
     * 'table' rakh diya hai jo 'dining_table_id' ko use karega.
     */
    public function table() 
    { 
        return $this->belongsTo(DiningTable::class, 'dining_table_id'); 
    }

    // Purana naam bhi rakha hai agar kahin aur use ho raha ho
    public function diningTable() 
    { 
        return $this->belongsTo(DiningTable::class, 'dining_table_id'); 
    }

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }

    public function items() 
    { 
        // Foreign key 'order_id' lazmi check karein OrderItem table mein
        return $this->hasMany(OrderItem::class, 'order_id'); 
    }

    /**
     * Status Accessor
     */
    public function getOrderStatusAttribute()
    {
        return $this->status;
    }
}