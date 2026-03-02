<?php

namespace App\Models;
<<<<<<< HEAD
use App\Models\DailyWorkDone;
=======
>>>>>>> 2ac17b5ed6aec8348ccae53244e4f31ced200780
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'position',
        'department_id',
        'salary',
        'hired_at',
        'profile_picture',
        'user_id',
    ];

    protected $hidden = ['password'];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function dailyTasks()
    {
        return $this->hasMany(EmployeeDailyTask::class);
    }
    public function comments()
{
    return $this->morphMany(EmployeeTaskComment::class, 'commented_by');
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }
    public function performances()
    {
        return $this->hasMany(Performance::class);
    }
<<<<<<< HEAD

    public function dailyWorks()
    {
        return $this->hasMany(DailyWorkDone::class);
    }
=======
>>>>>>> 2ac17b5ed6aec8348ccae53244e4f31ced200780

}
