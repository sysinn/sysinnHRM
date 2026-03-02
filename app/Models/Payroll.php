<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'basic_salary',
        'allowances',
        'deductions',
        'overtime_pay',
        'bonus',
        'increment',
        'increment_reason',
        'tax',
        'net_salary',
        'pay_date',
        'payment_method',
        'bank_account_number',
        'payment_status',
        'remarks'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}