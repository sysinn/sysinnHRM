<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
    ];

    // Relation with Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
