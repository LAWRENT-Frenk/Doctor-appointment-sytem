<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,id'
    ]);

    $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

    if ($request->has('permissions')) {
        $permissions = Permission::whereIn('id', $request->permissions)
            ->where('guard_name', 'web')
            ->pluck('name');
        $role->syncPermissions($permissions);
    }

    return redirect()->route('roles.index')->with('success', 'Role created successfully.');
}


    public function store_old(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);
    
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
    
        if ($request->has('permissions')) {
            // Get the permissions that exist
            $validPermissions = Permission::whereIn('id', $request->permissions)
                ->where('guard_name', 'web')
                ->pluck('id');
    
            // Synchronize only valid permissions
            $role->syncPermissions($validPermissions);
        }
    
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }
    
    public function update_old(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
