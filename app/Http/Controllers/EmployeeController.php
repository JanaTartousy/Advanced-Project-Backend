<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Store a new employee in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email',
                'dob' => 'required|date',
                'phone_number' => 'required|string|unique:employees,phone_number',
                'picture' => 'nullable|string',
            ]);

            $employee = Employee::create($validatedData);

            return response()->json([
                'message' => 'Employee created successfully',
                'employee' => $employee,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    'message' => 'Validation error',
                    'errors' => $e->errors(),
                ],
                422,
            );
        }
    }
}
