<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
{
    $roles = Role::withCount('users')->paginate(5); // Show 5 per page
    return view('roles.index', compact('roles'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Role added successfully!');
    }
}
