<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Employee;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index()
    {
        $performances = Performance::with('employee')->latest()->paginate(10);
        return view('performances.index', compact('performances'));
    }

  public function create()
{
    $employees = Employee::selectRaw("CONCAT(first_name, ' ', last_name) as full_name, id")
                         ->pluck('full_name', 'id');

    return view('performances.create', compact('employees'));
}


    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
            'review_date' => 'required|date',
            'reviewed_by' => 'nullable|string|max:255',
            'goals' => 'nullable|string|max:255',
            'achievements' => 'nullable|string|max:255',
            'improvement_area' => 'nullable|string|max:255',
            'training_recommended' => 'nullable|string|max:255',
            'status' => 'required|in:Excellent,Good,Average,Poor',
            'remarks' => 'nullable|string|max:500',
        ]);

        Performance::create($request->all());

        return redirect()->route('performances.index')
                         ->with('success', 'Performance review added successfully.');
    }

    public function show(Performance $performance)
    {
        return view('performances.show', compact('performance'));
    }

    public function edit(Performance $performance)
    {
        $employees = Employee::all();
        return view('performances.edit', compact('performance','employees'));
    }

    public function update(Request $request, Performance $performance)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
            'review_date' => 'required|date',
            'reviewed_by' => 'nullable|string|max:255',
            'goals' => 'nullable|string|max:255',
            'achievements' => 'nullable|string|max:255',
            'improvement_area' => 'nullable|string|max:255',
            'training_recommended' => 'nullable|string|max:255',
            'status' => 'required|in:Excellent,Good,Average,Poor',
            'remarks' => 'nullable|string|max:500',
        ]);

        $performance->update($request->all());

        return redirect()->route('performances.index')
                         ->with('success', 'Performance review updated successfully.');
    }

    public function destroy(Performance $performance)
    {
        $performance->delete();
        return redirect()->route('performances.index')
                         ->with('success', 'Performance review deleted successfully.');
    }

    // 📊 Performance summary method
    public function summary()
    {
        $summary = Performance::with('employee')
            ->selectRaw('employee_id, AVG(rating) as avg_rating, COUNT(*) as reviews_count')
            ->groupBy('employee_id')
            ->get();

        $topPerformers = $summary->sortByDesc('avg_rating')->take(5);
        $lowPerformers = $summary->sortBy('avg_rating')->take(5);

        return view('performances.summary', compact('summary','topPerformers','lowPerformers'));
    }
}
