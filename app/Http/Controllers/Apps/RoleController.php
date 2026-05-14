<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        
        // Count users per role
        foreach($roles as $role) {
            $role->users_count = \App\Models\User::role($role->name)->count();
            $role->users = \App\Models\User::role($role->name)->limit(4)->get();
        }

        // All users with their roles for the bottom table
        $allUsers = \App\Models\User::with('roles')->get();

        return view('content.apps.app-access-roles', compact('roles', 'permissions', 'allUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'modalRoleName' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->modalRoleName]);
        
        if($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Role created successfully.');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $request->validate([
            'modalRoleName' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->update(['name' => $request->modalRoleName]);
        
        if($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]); // Clear all if none selected
        }

        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if($role->name !== 'Super Admin') {
            $role->delete();
        }
        return redirect()->back()->with('success', 'Role deleted successfully.');
    }
}
