<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // Display a list of Roles.
    
    public function getRoles()
    {
        $roles = Role::all();
        return response()->json([
            'message' => 'Role created successfully',
            'roles' => $roles,
        ]);
    }
// Create a newly Role project in database.

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
// Dipslay a specific Role.

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
// Update a specific Role in database.
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
// Remove a specific Role in database.

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
