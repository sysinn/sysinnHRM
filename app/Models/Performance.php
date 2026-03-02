<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
class Performance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'rating',
        'review',
        'review_date',
        'reviewed_by',
        'goals',
        'achievements',
        'improvement_area',
        'training_recommended',
        'status',
        'remarks',
    ];

  public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}

}
