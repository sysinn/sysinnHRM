<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Module;
use Illuminate\Http\Request;

class RoleModuleController extends Controller
{
    public function edit(Role $role)
    {
        $modules = Module::orderBy('label')->get();
        $assigned = $role->modules->pluck('id')->toArray();
        return view('roles.edit_modules', compact('role', 'modules', 'assigned'));
    }

    public function update(Request $request, Role $role)
    {
        $moduleIds = $request->input('modules', []);
        $role->modules()->sync($moduleIds);
        return redirect()->route('role-modules.edit', $role->id)->with('success', 'Modules updated successfully.');
    }
}
