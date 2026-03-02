<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'label',
        'route',
        'icon',
        'roles',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'roles' => 'array', // Automatically cast JSON to array
    ];
}
