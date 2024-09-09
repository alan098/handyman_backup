<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', ['roles' => $roles]);
    }


    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', ['permissions' => $permissions]);

    }


    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);
        return redirect()->route('admin.roles.edit', $role)->with('info', 'El rol se creo con exito');
    }


    public function show( Role $role )
    {
        $role->load('permissions');
        return $role;
    }


    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }


    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => 'required']);
        $role->update($request->all());
        $role->permissions()->sync($request->permissions);
        return redirect()->route('admin.roles.edit', $role)->with('info', 'El rol se actualizo con exito');

    }


    public function destroy(Role $role )
    {
        $name=$role->name;
        $role->delete();

        return redirect()->route('admin.roles.index')->with('info','El rol ' .$name.' ha sido eliminado');
    }
}
