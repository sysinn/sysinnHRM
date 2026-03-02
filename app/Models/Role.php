<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        // return $this->hasMany(User::class);
        return $this->belongsToMany(User::class, 'role_user');
    }


    /**
     * Get the modules associated with the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function modules()
{
    return $this->belongsToMany(Module::class, 'role_module');
}

}
