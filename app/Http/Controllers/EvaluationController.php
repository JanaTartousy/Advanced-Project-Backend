<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Employee;
use App\Models\Kpi;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{

    public function AddEvaluation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'evaluation' => 'required|string|max:255',
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

    public function deleteEvaluation($id)
    {
        try {
            $evaluations = Evaluation::findOrFail($id);
            $evaluations->delete();

            return response()->json([
                'message' => 'Evaluation deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete evaluation.',
            ], 500);
        }
    }


    public function updateEvaluation(Request $request, $id)
    {
        // try {
        //     // find the evaluation record
        //     $evaluations = Evaluation::find($id);
        //     $validator=Validator::make($request->all(),[
        //         'employee_id'=>'nullable|exists:employees,id',
        //         'kpi_id'=>'nullable|exists:kpis,id',
        //         'date_evaluated'=>'nullable|date',
        //         'evaluation'=>'nullable|sting'
        //     ]);
        //     if($validator->fail()){
        //         return response()->json([
        //             'success'=>false,
        //             'message'=> $validator->errors(),
        //         ]);
        //     }

        //     $evaluations->update($validator->validated());

        //     return response()->json([
        //         'message' => 'Evaluation updated successfully',
        //         'Evaluation'=>$evaluations
        //     ]);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'error' => 'Evaluation update failed',
        //         'message' => $e->getMessage()
        //     ], 500);
        // }
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
        $evaluation=Evaluation::find($id);
        $evaluation->update($validator->validated());

    
        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $evaluation,
        ]);
    }
    

    public function getAllEvaluations()
    {
        try {
            $evaluations = Evaluation::with(['employees', 'kpis'])->get();
            return response()->json(['evaluations' => $evaluations], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve evaluations.'], 500);
        }
    }


    public function getEvaluationById($id)
    {
        try {
            $evaluation = Evaluation::with('employees','kpis')->find($id);

            return response()->json([
                'evaluation' => $evaluation,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Evaluation retrieval failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}