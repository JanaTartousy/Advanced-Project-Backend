<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' ,
            'dob' => 'required|date',
            'phone_number' => 'required|string|unique:employees,phone_number,' ,
            'picture' => 'nullable|string',
            'team_id' => 'nullable|exists:teams,id',
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

        $employee = Employee::create($validator);

        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully',
            'employee' => $employee,
        ]);
    }
    public function getEmployee($id)
    {
        $employee = Employee::fine($id);

        if (!$employee) {
            return response()->json(
                [
                    'message' => 'Employee not found',
                ],
                404,
            );
        }

        return response()->json([
            'employee' => $employee,
        ]);
    }

    public function getEmployees()
    {
        $employees = Employee::all();
        return response()->json([
            'employees' => $employees,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'email|unique:employees,email,' . $id,
            'dob' => 'date',
            'phone_number' => 'string|unique:employees,phone_number,' . $id,
            'picture' => 'string',
            'team_id' => 'exists:teams,id',
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

        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(
                [
                    'message' => 'Employee not found',
                ],
                404,
            );
        }

        $employee->update($request->all());

        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $employee,
        ]);
    }

    public function delete($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(
                [
                    'message' => 'Employee not found',
                ],
                404,
            );
        }

        $employee->delete();
        return response()->json([
            'message' => 'Employee deleted successfully',
        ]);
    }
}
