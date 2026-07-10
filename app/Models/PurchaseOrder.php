<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    // Table name specify kar dena achi practice hai
    protected $table = 'purchase_orders';

    // Mass assignment ke liye fields
    protected $fillable = [
        'supplier_id',
        'po_number',
        'order_date',
        'total_amount',
        'status',
        'notes'
    ];

    /**
     * Ek Purchase Order ka aik hi Supplier hota hai (Relationship)
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    /**
     * Ek Purchase Order mein boht saaray items ho saktay hain (Relationship)
     * Make sure aapka PurchaseOrderItem model bana hua hai.
     */
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id', 'id');
    }

    /**
     * Date ko carbon instance mein cast karna taake formatting asaan ho
     */
    protected $casts = [
        'order_date' => 'date',
        'total_amount' => 'decimal:2',
    ];
}