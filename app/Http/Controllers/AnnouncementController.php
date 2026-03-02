<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::orderBy('publish_date', 'desc')->get();
        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required',
        'publish_date' => 'nullable|date',
        'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'is_active' => 'boolean',
    ]);

    $data = $request->all();

    // ✅ FIX FEATURED IMAGE
    if ($request->hasFile('featured_image')) {
        $data['featured_image'] = $request->file('featured_image')
            ->store('announcements', 'public');
    }

    Announcement::create($data);

    return redirect()
        ->route('announcements.index')
        ->with('success', 'Announcement created.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
