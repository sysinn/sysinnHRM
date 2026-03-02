<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index($employeeId)
{
    $employee = Employee::with('documents')->findOrFail($employeeId);
    return view('empdoc.index', compact('employee'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $employeeId)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
    ]);

    $file = $request->file('document');
    $path = $file->store('employee-documents');

    EmployeeDocument::create([
        'employee_id' => $employeeId,
        'title' => $request->title,
        'file_path' => $path,
    ]);

    return back()->with('success', 'Document uploaded successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(EmployeeDocument $employeeDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeDocument $employeeDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeDocument $employeeDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeDocument $employeeDocument)
    {
         if (Storage::exists($employeeDocument->file_path)) {
        Storage::delete($employeeDocument->file_path);
    }

    // Delete the database record
    $employeeDocument->delete();

    return back()->with('success', 'Document deleted successfully.');
    }

    public function listAll()
{
    $documents = EmployeeDocument::with('employee')->latest()->paginate(10);
    $firstEmployee = Employee::first(); // or any logic

    return view('empdoc.list', [
        'documents' => $documents,
        'employee' => $firstEmployee
    ]);
}

}
