<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'parent_id',
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

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

     public function role()
    {
        return $this->belongsTo(Role::class, 'roles'); // 'roles' is your foreign key column
    }
}
