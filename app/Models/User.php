<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'status',
        // 'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Roles relationship (many-to-many)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Comments relationship (polymorphic)
     */
    public function comments()
    {
        return $this->morphMany(EmployeeTaskComment::class, 'commented_by');
    }

    /**
     * Link to employee record
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Attendances
     */
    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class);
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->status == 1;
    }

    /**
     * Check if user is inactive
     */
    public function isInactive()
    {
        return $this->status == 0;
    }

    /**
     * Check if the user has a specific role by name.
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        if (is_array($role)) {
            return $this->roles->whereIn('name', $role)->isNotEmpty();
        }

        return false;
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole($roleName)
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $this->roles()->attach($role);
    }
}
