<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'dining_table_id',
        'customer_name',
        'phone',
        'email',
        'reservation_date',
        'reservation_time',
        'party_size',
        'status',
        'notes',
    ];

    protected $casts = [
        'reservation_date' => 'date',
    ];

    public function diningTable()
    {
        return $this->belongsTo(DiningTable::class);
    }
}
