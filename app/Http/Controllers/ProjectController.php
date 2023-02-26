<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function getProjects()
{
    $projects = Project::with('team.employees.employeeRole.role')->get();

    return response()->json([
        'message' => 'Projects retrieved successfully',
        'projects' => $projects,
    ]);
}

/**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse
 */
public function getProject($id)
{
    $project = Project::with('team.employees', 'employeesWithRoles')->find($id);

    if (!$project) {
        return response()->json([
            'message' => 'Project not found',
        ], 404);
    }

    return response()->json([
        'message' => 'Project retrieved successfully',
        'project' => $project,
    ]);
}



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
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
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
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
