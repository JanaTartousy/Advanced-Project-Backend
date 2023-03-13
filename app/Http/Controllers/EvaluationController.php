<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Employee;
use App\Models\Kpi;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{
    /**
     * Add a newly created evaluation in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function AddEvaluation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'evaluation' => 'required|numeric|min:0|max:10',
            'date_evaluated' => 'required|date',
            'employee_id' => 'nullable|exists:employees,id',
            'kpi_id' => 'nullable|exists:kpis,id',
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

        $evaluation = new Evaluation($validator->validated());

        $evaluation->save();

        return response()->json([
            'success' => true,
            'message' => 'Evaluation created successfully',
            'Evaluation' => $evaluation,
        ]);
    }

    /**
     * Remove the specified evaluation from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function deleteEvaluation($id)
    {
        try {
            $evaluations = Evaluation::findOrFail($id);
            $evaluations->delete();

            return response()->json([
                'message' => 'Evaluation deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to delete evaluation.',
                ],
                500,
            );
        }
    }


     /**
     * Update the specified evaluation in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateEvaluation(Request $request, $id)
    {


            $validator = Validator::make($request->all(), [
            'evaluation' => 'string|max:255',
            'date_evaluated' => 'date',
            'employee_id' => 'exists:employees,id',
            'kpi_id' => 'exists:kpis,id',
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
        $evaluation = Evaluation::find($id);
        $evaluation->update($validator->validated());

        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $evaluation,
        ]);
    }

    /**
     * Display a listing of the evaluations.
     *
     * @param Request $request
     * @return JsonResponse
     */

     public function getAllEvaluations(Request $request)
{   
    $pageNumber = $request->query("page");
    $perPage = $request->query("per_page");

    try {
        if ($name = $request->query('search')) {
            $evaluations = Evaluation::with(['employees', 'kpis'])
                ->whereHas('employees', function ($query) use ($name) {
                    $query->where('name', 'LIKE', '%' . $name . '%');
                })
                ->paginate($perPage ?: 20);

            if ($evaluations->isEmpty()) {
                return response()->json(['message' => 'No evaluations found for the employee.'], 404);
            }

            return response()->json([
                'message' => 'Evaluations retrieved successfully for the employee.',
                'evaluations' => $evaluations,
            ]);
        }

        $evaluations = Evaluation::with(['employees', 'kpis'])->paginate($perPage ?: 20);

        return response()->json([
            'message' => 'Evaluations retrieved successfully.',
            'evaluations' => $evaluations,
        ]);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to retrieve evaluations.'], 500);
    }
}
     /**
     * Display the specified evaluation.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function getEvaluationById($id)
    {
        try {
            $evaluation = Evaluation::with('employees', 'kpis')->find($id);

            return response()->json([
                'evaluation' => $evaluation,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => 'Evaluation retrieval failed',
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
