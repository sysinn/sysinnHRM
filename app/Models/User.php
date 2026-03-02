<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // 'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
        protected function casts(): array
        {
            return [
                'email_verified_at' => 'datetime',
                'password' => 'hashed',
            ];
        }
        public function roles()
        {
            return $this->belongsToMany(Role::class, 'role_user');
            // return $this->belongsTo(Role::class);
        }
       public function comments()
        {
            return $this->morphMany(EmployeeTaskComment::class, 'commented_by');
        }

        public function employee()
        {
            return $this->hasOne(Employee::class);
        }
        public function attendances()
        {
            return $this->hasMany(\App\Models\Attendance::class);
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

