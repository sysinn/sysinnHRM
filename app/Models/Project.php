<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'client_name',
        'description',
        'status',
        'priority',
        'progress',
        'start_date',
        'end_date',
        'assigned_to',
    ];

    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
