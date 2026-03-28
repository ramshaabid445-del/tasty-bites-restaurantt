<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Industrial Practice: Sirf wahi fields likhein jo form se save honi hain.
     */
    protected $fillable = [
        'name',
        'company_name',
        'phone',
        'email',
        'address',
        'opening_balance',
        'status'
    ];

    /**
     * Type Casting
     * Taake balance hamesha decimal/float mein milay, string mein nahi.
     */
    protected $casts = [
        'opening_balance' => 'decimal:2',
        'status' => 'boolean',
    ];

    /**
     * Relationship: Purchase Orders
     * Kal ko jab hum Purchase Order module banayenge, 
     * toh ye supplier ke saare bill nikaal kar dega.
     */
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    /**
     * Scope: Active Suppliers
     * Controller mein use karne ke liye: Supplier::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}