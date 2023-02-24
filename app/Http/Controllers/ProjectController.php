<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request  
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'finished' => 'boolean',
        ]);

        $project = Project::create($validatedData);

        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project,
        ]);
    }
}
