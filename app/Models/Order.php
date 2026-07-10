<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'dining_table_id', 'table_id', 'customer_name', 'customer_phone',
        'customer_email', 'customer_address',
        'order_type', 'status', 'sub_total', 'tax_amount', 'discount_amount', 'total_amount',
        'payment_method', 'payment_status', 'notes', 'assigned_staff_id', 'staff_id', 'employee_id',
        'estimated_ready_at'
    ];

    protected $casts = [
        'estimated_ready_at' => 'datetime',
        'preparing_at' => 'datetime',
        'ready_at' => 'datetime',
    ];

    public function table() 
    { 
        // Fallback checks for column variations inside the model instance context
        $foreignKey = Schema::hasColumn('orders', 'dining_table_id') ? 'dining_table_id' : 'table_id';
        return $this->belongsTo(DiningTable::class, $foreignKey); 
    }

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
        return $this->hasMany(OrderItem::class, 'order_id'); 
    }

    public function getOrderStatusAttribute()
    {
        return $this->status;
    }
}
