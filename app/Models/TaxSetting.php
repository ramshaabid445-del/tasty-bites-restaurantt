<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxSetting extends Model
{
    protected $fillable = ['tax_name', 'tax_rate', 'is_active'];
}