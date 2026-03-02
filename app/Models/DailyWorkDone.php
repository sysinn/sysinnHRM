<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class DailyWorkDone extends Model
{
    use HasFactory;
    protected $table = 'daily_work_done';
    protected $fillable = [
        'employee_id',
        'department_id',
        'project_id',
        'task_type',
        'quantity',
        'status',
        'detail',
        'url',
        'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function employee()
{
    return $this->belongsTo(Employee::class);
}


protected $casts = [
    'date' => 'date', // ✅ so you can use Carbon
];

}