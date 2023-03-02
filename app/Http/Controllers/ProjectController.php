<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the project.
     *
     * @return JsonResponse
     */
    public function getProjects(Request $request)
    {
        $perPage = $request->query('per_page');

        if($name=$request->query('search')){
        $project = Project::where('name', 'LIKE', '%' . $name . '%')->paginate($perPage ?: 20);;

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        return response()->json([
            'message' => 'Projects retrieved successfully',
            'projects' => $project,
        ]);
    }
        
            
        $projects = Project::with('team.employees.employeeRole.role')->paginate($perPage ?: 20);
        

        return response()->json([
            'message' => 'Projects retrieved successfully',
            'projects' => $projects,
        ]);
    }

    /**
     * Display the specified project.
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
     * Store a newly created project in database.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'finished' => ['boolean'],
            'team_id' => ['nullable', 'exists:teams,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = Project::create($validator->validated());

        return response()->json(['project' => $project]);
    }

    /**
     * Update the specified project in database.
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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->update($validator->validated());

        return response()->json(['project' => $project]);
    }

    /**
     * Remove the specified project from database.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $project = Project::find($id);

        if ($project) {
            $project->delete();
            return response()->json(['message' => 'Project deleted successfully']);
        } else {
            return response()->json(['message' => 'Project not found'], 404);
        }
    }

}
