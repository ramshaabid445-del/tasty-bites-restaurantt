<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wastage extends Model
{
    use HasFactory;

    // Saare columns ko fillable kar diya taake store method mein masla na aaye
    protected $guarded = [];

    /**
     * Relationship: Ek wastage entry kisi ek Raw Material se judi hoti hai.
     */
    public function raw_material()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id', 'id');
    }

    /**
     * Relationship: Ek wastage entry kisi ek User (Staff/Admin) ne record ki hoti hai.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}