<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentController extends Controller
{
    // Document type options
    const DOCUMENT_TYPES = [
        'contract' => 'Contract',
        'offer_letter' => 'Offer Letter',
        'cnic' => 'CNIC',
        'experience_certificate' => 'Experience Certificate',
        'other' => 'Other'
    ];

    /**
     * Display a listing of the resource.
     */
public function index($employeeId)
{
    $employee = Employee::with('documents')->findOrFail($employeeId);
    $documentTypes = self::DOCUMENT_TYPES;
    return view('empdoc.index', compact('employee', 'documentTypes'));
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
        'document_type' => 'required|in:contract,offer_letter,cnic,experience_certificate,other',
        'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
    ]);

    $file = $request->file('document');
    $path = $file->store('employee-documents');

    EmployeeDocument::create([
        'employee_id' => $employeeId,
        'title' => $request->title,
        'document_type' => $request->document_type,
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
        $path = $this->getFilePath($employeeDocument->file_path);
        
        if ($path && file_exists($path)) {
            unlink($path);
        }

        // Delete the database record
        $employeeDocument->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    public function listAll()
{
    $documents = EmployeeDocument::with('employee')->latest()->paginate(10);
    $employees = Employee::all();
    $documentTypes = self::DOCUMENT_TYPES;

    return view('empdoc.list', [
        'documents' => $documents,
        'employees' => $employees,
        'documentTypes' => $documentTypes
    ]);
}

    /**
     * Get the actual file path from various possible locations.
     */
    private function getFilePath($filePath)
    {
        // Check in storage/app/private/
        $privatePath = storage_path('app/private/' . $filePath);
        if (file_exists($privatePath)) {
            return $privatePath;
        }
        
        // Check in storage/app/public/
        $publicPath = storage_path('app/public/' . $filePath);
        if (file_exists($publicPath)) {
            return $publicPath;
        }
        
        // Check in storage/app/
        $appPath = storage_path('app/' . $filePath);
        if (file_exists($appPath)) {
            return $appPath;
        }
        
        return null;
    }

    /**
     * Download a document.
     */
    public function download(EmployeeDocument $employeeDocument)
    {
        $path = $this->getFilePath($employeeDocument->file_path);
        
        if (!$path) {
            abort(404, 'File not found: ' . $employeeDocument->file_path);
        }
        
        return response()->download($path, $employeeDocument->title);
    }

    /**
     * View a document.
     */
    public function view(EmployeeDocument $employeeDocument)
    {
        $path = $this->getFilePath($employeeDocument->file_path);
        
        if (!$path) {
            abort(404, 'File not found');
        }
        
        $mimeType = mime_content_type($path);
        
        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $employeeDocument->title . '"'
        ]);
    }

}
