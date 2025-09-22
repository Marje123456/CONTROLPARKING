<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'amount_exceeded',
        'description',
        'is_active',
    ];
}
