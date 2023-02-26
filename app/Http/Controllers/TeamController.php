<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function getTeams()
    {
        $teams = Team::with('employees')->get();
        return response()->json([
            'success' => true,
            'teams' => $teams,
        ]);
    }

    public function getTeam($id)
    {
        $team = Team::with('employees')->find($id);

        if (!$team) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Team not found',
                ],
                404,
            );
        }

        return response()->json([
            'success' => true,
            'team' => $team,
        ]);
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:teams|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()->first(),
                ],
                422,
            );
        }

        $team = Team::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'message' => 'Team created successfully',
            'team' => $team,
        ]);
    }
    public function edit(Team $team)
    {
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, $id)
    {
        $team = Team::find($id);
        if (!$team) {
            return response()->json(
                [
                    'message' => 'Team not found',
                ],
                404,
            );
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:teams,name,' . $team->id . '|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()->first(),
                ],
                422,
            );
        }

        $name = $request->input('name');

        $team->update([
            'name' => $name,
        ]);

        return response()->json([
            'message' => 'Team updated successfully',
            'team' => $team,
        ]);
    }

    public function destroy($id)
    {
        $team = Team::find($id);
        if (!$team) {
            return response()->json(
                [
                    'message' => 'Team not found',
                ],
                404,
            );
        }

        $team->delete();
        return response()->json([
            'message' => 'Team deleted successfully',
        ]);
    }
}
