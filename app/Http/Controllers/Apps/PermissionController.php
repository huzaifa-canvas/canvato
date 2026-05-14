<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles')->get();
        return view('content.apps.app-access-permission', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'modalPermissionName' => 'required|string|max:255|unique:permissions,name'
        ]);

        Permission::create(['name' => $request->modalPermissionName]);

        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        
        $request->validate([
            'modalPermissionName' => 'required|string|max:255|unique:permissions,name,' . $permission->id
        ]);

        $permission->update(['name' => $request->modalPermissionName]);

        return redirect()->back()->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        
        return redirect()->back()->with('success', 'Permission deleted successfully.');
    }
}
