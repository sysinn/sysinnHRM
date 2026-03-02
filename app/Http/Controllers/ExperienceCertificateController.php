<?php

namespace App\Http\Controllers;
use App\Models\ExperienceCertificate;
use App\Models\Employee;
use Illuminate\Http\Request;
use PDF; // using barryvdh/laravel-dompdf

class ExperienceCertificateController extends Controller
{
    public function index()
    {
        $certificates = ExperienceCertificate::with('employee')->latest()->get();
        return view('certificates.index', compact('certificates'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('certificates.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required',
            'designation' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $certificate = ExperienceCertificate::create($data);

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully.');
    }

    public function download($id)
    {
        $certificate = ExperienceCertificate::with('employee')->findOrFail($id);
        $pdf = PDF::loadView('certificates.pdf', compact('certificate'));
        return $pdf->download('experience_certificate.pdf');
    }
}
