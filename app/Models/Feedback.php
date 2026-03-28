<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Table ka naam agar plural hai toh Laravel khud hi dhoond leta hai, 
    // lekin safe side ke liye hum define kar dete hain.
    protected $table = 'feedbacks';

    // Kaunse columns database mein save ho sakte hain
    protected $fillable = [
        'customer_id',
        'rating',
        'comment',
        'source'
    ];

    /**
     * Relationship: Ek feedback hamesha ek customer ka hota hai.
     * Is se aap $feedback->customer->name access kar sakenge.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}