<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the team.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTeams(Request $request)
    {   $page=$request->query('page');
        $perPage = $request->query('per_page');
        $teams = Team::with('employees')->paginate($perPage ?: 10,['*'],'page',$page);
        return response()->json([
            'success' => true,
            'teams' => $teams,
        ]);
    }

    /**
     * Display the specified team.
     *
     * @param  int  $id
     * @return JsonResponse
     */
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
    /**
     * Store a newly created team in database.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create()
    {
        return view('teams.create');
    }
    /**
     * Store a newly created team in database.
     *
     * @param Request $request
     * @return JsonResponse
     */
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
    /**
     * Update the specified team in database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
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
    /**
     * Remove the specified team from database.
     *
     * @param  int  $id
     * @return JsonResponse
     */
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
