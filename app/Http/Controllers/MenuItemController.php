<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Role;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('parent')
            ->paginate(10) // ✅ paginate so links() works
            ->through(function ($item) {
                // Convert roles (JSON or comma-separated IDs) to names
                $roleIds = is_array($item->roles) 
                    ? $item->roles 
                    : json_decode($item->roles, true);

                if (!is_array($roleIds)) {
                    $roleIds = explode(',', $item->roles ?? '');
                }

                $item->role_names = Role::whereIn('id', array_filter($roleIds))
                    ->pluck('name')
                    ->join(', ');

                return $item;
            });

        return view('menu_items.index', compact('menuItems'));
    }

    public function create()
    {
        $parents = MenuItem::pluck('label', 'id');
        return view('menu_items.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'icon'  => 'nullable|string|max:255',
            'roles' => 'nullable'
        ]);

        MenuItem::create($request->all());

        return redirect()->route('menu-items.index')->with('success', 'Menu Item created successfully.');
    }

    public function edit(MenuItem $menu_item)
    {
        $parents = MenuItem::where('id', '!=', $menu_item->id)->pluck('label', 'id');
        return view('menu_items.edit', compact('menu_item', 'parents'));
    }

    public function update(Request $request, MenuItem $menu_item)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'icon'  => 'nullable|string|max:255',
            'roles' => 'nullable'
        ]);

        $menu_item->update($request->all());

        return redirect()->route('menu-items.index')->with('success', 'Menu Item updated successfully.');
    }

    public function destroy(MenuItem $menu_item)
    {
        $menu_item->delete();
        return redirect()->route('menu-items.index')->with('success', 'Menu Item deleted successfully.');
    }
}
