<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'raw_material_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    // Ye item kis material ka hai
    public function material()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id');
    }
}