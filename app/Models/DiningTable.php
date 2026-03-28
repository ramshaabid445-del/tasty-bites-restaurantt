<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiningTable extends Model
{
    use HasFactory;

    // Aapki migration ke mutabiq table ka naam ye hai
    protected $table = 'dining_tables'; 

    protected $guarded = [];
}