<?php

namespace App\Http\Controllers;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payroll::with('employee');
        
        // Search by employee name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('employee', function($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%");
            });
        }
        
        // Filter by payment status
        if ($request->has('status') && $request->status) {
            $query->where('payment_status', $request->status);
        }
        
        // Filter by month
        if ($request->has('month') && $request->month) {
            $query->whereMonth('pay_date', $request->month);
        }
        
        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->whereYear('pay_date', $request->year);
        }
        
        $payrolls = $query->orderBy('pay_date', 'desc')->get();
        
        // Calculate statistics
        $totalPayroll = Payroll::sum('net_salary');
        $paidAmount = Payroll::where('payment_status', 'Paid')->sum('net_salary');
        $pendingAmount = Payroll::where('payment_status', 'Pending')->sum('net_salary');
        $totalEmployees = Payroll::distinct()->count('employee_id');
        $paidCount = Payroll::where('payment_status', 'Paid')->count();
        $pendingCount = Payroll::where('payment_status', 'Pending')->count();
        
        // Get unique years for filter
        $years = Payroll::selectRaw('YEAR(pay_date) as year')->distinct()->pluck('year');
        
        return view('payroll.index', compact(
            'payrolls', 'totalPayroll', 'paidAmount', 'pendingAmount', 
            'totalEmployees', 'paidCount', 'pendingCount', 'years'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $employees = \App\Models\Employee::all();
    return view('payroll.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $net_salary = 
        $request->basic_salary + 
        $request->allowances + 
        $request->overtime_pay + 
        $request->bonus +
        $request->increment - 
        ($request->deductions + $request->tax);

    Payroll::create([
        'employee_id' => $request->employee_id,
        'basic_salary' => $request->basic_salary,
        'allowances' => $request->allowances,
        'overtime_pay' => $request->overtime_pay,
        'bonus' => $request->bonus,
        'increment' => $request->increment,
        'increment_reason' => $request->increment_reason,
        'deductions' => $request->deductions,
        'tax' => $request->tax,
        'net_salary' => $net_salary,
        'pay_date' => $request->pay_date,
        'payment_method' => $request->payment_method,
        'bank_account_number' => $request->bank_account_number,
        'payment_status' => $request->payment_status,
        'remarks' => $request->remarks
    ]);

    return redirect()->route('payroll.index')
        ->with('success', 'Payroll processed successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);
        return view('payroll.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);
        $employees = Employee::all();
        return view('payroll.edit', compact('payroll', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payroll = Payroll::findOrFail($id);
        
        $net_salary = 
            $request->basic_salary + 
            $request->allowances + 
            $request->overtime_pay + 
            $request->bonus +
            $request->increment - 
            ($request->deductions + $request->tax);

        $payroll->update([
            'employee_id' => $request->employee_id,
            'basic_salary' => $request->basic_salary,
            'allowances' => $request->allowances,
            'overtime_pay' => $request->overtime_pay,
            'bonus' => $request->bonus,
            'increment' => $request->increment,
            'increment_reason' => $request->increment_reason,
            'deductions' => $request->deductions,
            'tax' => $request->tax,
            'net_salary' => $net_salary,
            'pay_date' => $request->pay_date,
            'payment_method' => $request->payment_method,
            'bank_account_number' => $request->bank_account_number,
            'payment_status' => $request->payment_status,
            'remarks' => $request->remarks
        ]);

        return redirect()->route('payroll.index')
            ->with('success', 'Payroll updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
        
        return redirect()->route('payroll.index')
            ->with('success', 'Payroll record deleted successfully');
    }

    /**
     * Export payroll data to CSV
     */
    public function export()
    {
        $payrolls = Payroll::with('employee')->get();
        
        $filename = 'payroll_export_' . date('Y_m_d_H_i_s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($payrolls) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'ID',
                'Employee Name',
                'Basic Salary',
                'Allowances',
                'Overtime',
                'Bonus',
                'Deductions',
                'Tax',
                'Net Salary',
                'Pay Date',
                'Payment Method',
                'Status',
                'Remarks'
            ]);
            
            // Data rows
            foreach ($payrolls as $payroll) {
                fputcsv($file, [
                    $payroll->id,
                    ($payroll->employee->first_name ?? '') . ' ' . ($payroll->employee->last_name ?? ''),
                    $payroll->basic_salary,
                    $payroll->allowances,
                    $payroll->overtime_pay,
                    $payroll->bonus,
                    $payroll->deductions,
                    $payroll->tax,
                    $payroll->net_salary,
                    $payroll->pay_date,
                    $payroll->payment_method,
                    $payroll->payment_status,
                    $payroll->remarks
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
