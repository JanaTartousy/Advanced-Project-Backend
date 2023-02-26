<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EmployeeRole;

class EmployeeRoleController extends Controller
{
    public function getRolesByProject($project_id)
    {
        $roles = EmployeeRole::where('project_id', $project_id)->get();

        return response()->json([
            'message' => 'Roles retrieved successfully',
            'roles' => $roles,
        ]);
    }

    public function assignRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'role_id' => 'required|exists:roles,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'validation error',
                    'error' => $validator->errors(),
                ],
                422,
            );
        }

        $employeeRole = EmployeeRole::create([
            'employee_id' => $request->input('employee_id'),
            'role_id' => $request->input('role_id'),
            'project_id' => $request->input('project_id'),
        ]);

        return response()->json([
            'message' => 'Role assigned successfully',
            'employee_role' => $employeeRole,
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        $employeeRole = EmployeeRole::find($id);

        if (!$employeeRole) {
            return response()->json(
                [
                    'message' => 'Employee role not found',
                ],
                404,
            );
        }

        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'role_id' => 'required|exists:roles,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }

        $employeeRole->employee_id = $request->input('employee_id');
        $employeeRole->role_id = $request->input('role_id');
        $employeeRole->project_id = $request->input('project_id');
        $employeeRole->save();

        return response()->json([
            'message' => 'Employee role updated successfully',
            'employee_role' => $employeeRole,
        ]);
    }

    public function deleteRole($id)
    {
        $employeeRole = EmployeeRole::find($id);

        if (!$employeeRole) {
            return response()->json(
                [
                    'message' => 'Employee role not found',
                ],
                404,
            );
        }

        $employeeRole->delete();

        return response()->json([
            'message' => 'Employee role deleted successfully',
        ]);
    }
}
