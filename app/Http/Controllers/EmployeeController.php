<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; 

class EmployeeController extends Controller
{
    // Add a newly created Employee in database.

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,',
            'dob' => 'required|date',
            'phone_number' => 'required|string|unique:employees,phone_number,',
            'team_id' => 'nullable|exists:teams,id',
            'picture' => 'required|image|max:2048', // Added validation for picture
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
    
        $employee = new Employee($validator->validated());
    
        // Save the picture to storage
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $filename = time() . '_' . $picture->getClientOriginalName();
            $imagePath=$picture->storeAs('public/employee_pictures', $filename);
            $employee->picture = $imagePath;
        }
    
        $employee->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully',
            'employee' => $employee,
        ]);
    }
    
    // Display a specific Employee.

    public function getEmployee($id)
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

    return response()->json([
        'employee' => $employee,
    ]);
}
// Display list of all Employees.

    public function getEmployees()
    {
        $employees = Employee::with('team.projects','employeeRole.projects')->get();
        return response()->json([
            'employees' => $employees,
        ]);
    }

 // Update the specific Employee.

public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'first_name' => 'string|max:255',
        'last_name' => 'string|max:255',
        'email' => 'email|unique:employees,email,' . $id,
        'dob' => 'date',
        'phone_number' => 'string|unique:employees,phone_number,' . $id,
        'picture' => 'image|max:2048', // limit picture size to 2MB
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
    $employee->update($validator->validated());
    
    if ($request->hasFile('picture')) {
        Storage::delete($employee->picture); // delete old picture
        $picture = $request->file('picture');
        $filename = time() . '_' . $picture->getClientOriginalName();
        $imagePath=$picture->storeAs('public/employee_pictures', $filename);
        $employee->picture = $imagePath;
    }
    
    $employee->save();

    return response()->json([
        'message' => 'Employee updated successfully',
        'employee' => $employee,
    ]);
}
// Remove a specific Employee.

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
    
        Storage::delete($employee->picture); // delete employee's picture
        $employee->delete();
    
        return response()->json([
            'message' => 'Employee deleted successfully',
        ]);
    }
}
