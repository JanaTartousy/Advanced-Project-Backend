<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeRole;

class EmployeeRoleController extends Controller
{
    public function assignRole(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'role_id' => 'required|exists:roles,id',
                'project_id' => 'required|exists:projects,id',
            ]);

            $employeeRole = EmployeeRole::create([
                'employee_id' => $request->input('employee_id'),
                'role_id' => $request->input('role_id'),
                'project_id' => $request->input('project_id'),
            ]);

            return response()->json([
                'message' => 'Role assigned successfully',
                'employee_role' => $employeeRole,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    'message' => 'validation error',
                    'error' => $e->errors(),
                ],
                422,
            );
        }
    }
}
