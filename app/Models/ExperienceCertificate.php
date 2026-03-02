<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceCertificate extends Model
{
    protected $fillable = [
        'employee_id', 'designation', 'start_date', 'end_date', 'remarks',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
