<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    //

public function index(){

    $roles       = Role::with('permissions')->get();
    $permissions = Permission::all();

    return view('role_management.management', compact('roles', 'permissions'));
}

public function create_role(Request $request){
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,name',
    ]);

    $role = Role::create(['name' => $request->name]);

    $role->syncPermissions($request->permissions ?? []);

    return redirect()->route('role_management')->with('success', 'Role created successfully.');
}

public function edit_role(Request $request, $id){

    $role = Role::findOrFail($id);

    if ($role->name === 'admin') {
        return redirect()->back()->with('error', 'Cannot modify the admin role.');
    }

    $request->validate([
        'name'          => 'required|unique:roles,name,' . $id,
        'permissions'   => 'array',
        'permissions.*' => 'exists:permissions,name',
    ]);

    $role->name = $request->name;

    $role->save();

    $role->syncPermissions($request->permissions ?? []);

    return redirect()->route('role_management')->with('success', 'Role updated successfully.');
}

public function destroy($id){
    $role = Role::findOrFail($id);

    if ($role->name === 'admin') {
        return redirect()->back()->with('error', 'Cannot delete the admin role.');
    }

    $role->delete();

    return redirect()->route('role_management')->with('Success', 'Role deleted successfully.');

}
}
