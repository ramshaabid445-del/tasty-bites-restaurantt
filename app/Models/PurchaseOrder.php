<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'po_number',
        'order_date',
        'total_amount',
        'status',
        'notes'
    ];

    // Ek PO ka ek hi Supplier hota hai
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Ek PO mein boht saaray items ho saktay hain
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}