<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function getProjects(Request $request)
    {
        $pageNumber=$request->query("page");
        $perPage=$request->query("per_page");
        if($pageNumber){
            
            $projects = Project::with('team.employees.employeeRole.role')->paginate($perPage||10, ['*'], 'page', $pageNumber);
            }else{
        $projects = Project::with('team.employees.employeeRole.role')->get();}

        return response()->json([
            'message' => 'Projects retrieved successfully',
            'projects' => $projects,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function getProject($id)
    {
        $project = Project::with('team.employees.employeeRole.role')->find($id);

        if (!$project) {
            return response()->json(
                [
                    'message' => 'Project not found',
                ],
                404,
            );
        }

        // Extract employees with their roles
        $employees = collect();
        foreach ($project->team->employees as $employee) {
            $employee_role = $employee->employeeRole;
            if ($employee_role) {
                $role = $employee_role->role;
                if ($role) {
                    $employees->push([
                        'id' => $employee->id,
                        'first_name' => $employee->first_name,
                        'last_name' => $employee->last_name,
                        'email' => $employee->email,
                        'role' => $role->name,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Project retrieved successfully',
            'project' => [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'finished' => $project->finished,
                'team_id' => $project->team_id,
                'employees' => $employees,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'finished' => 'boolean:default false',
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

        $project = Project::create($validator->validated());

        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'finished' => 'nullable|boolean',
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

        $project = Project::find($id);

        if (!$project) {
            return response()->json(
                [
                    'message' => 'Project not found',
                ],
                404,
            );
        }

        $project->update($validator->validated());

        return response()->json([
            'message' => 'Project updated successfully',
            'project' => $project,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(
                [
                    'message' => 'Project not found',
                ],
                404,
            );
        }

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
        ]);
    }
}
