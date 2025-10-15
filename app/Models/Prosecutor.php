<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prosecutor extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'dni',
        'phone',
        'user_id',
        'is_active',
    ];

    /**
     * Obtener el usuario asociado al fiscal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
