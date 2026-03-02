<?php
namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the menu items.
     */
    public function index()
    {
        $menuItems = MenuItem::all(); // No roles involved
        return view('menu_items.index', compact('menuItems'));
    }

    /**
     * Show the form to create a new menu item.
     */
    public function create()
    {
        return view('menu_items.create');
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        MenuItem::create($validated);

        return redirect()->route('menu-items.index')->with('success', 'Menu item added successfully!');
    }
}
