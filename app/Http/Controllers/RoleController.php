<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function getRoles()
    {
        $roles = Role::all();
        return response()->json([
            'message' => 'Role created successfully',
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {

        $role = Role::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'message' => 'Role created successfully',
            'role' => $role,
        ]);
    }

    public function getRole($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ], 404);
        }

        return response()->json([
            'role' => $role,
        ]);
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ], 404);
        }

        $name = $request->input('name');
        if (empty($name)) {
            return response()->json([
                'message' => 'Name cannot be empty'
            ], 422);
        }

        $role->update([
            'name' => $name,
        ]);

        return response()->json([
            'message' => 'Role updated successfully',
            'role' => $role,
        ]);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'message' => 'Role not found',
            ], 404);
        }

        $role->delete();
        return response()->json([
            'message' => 'Role deleted successfully',
        ]);
    }
}
