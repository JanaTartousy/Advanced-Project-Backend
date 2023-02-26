<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Employee;
use App\Models\KPI;

class EvaluationController extends Controller
{
  
    public function AddEvaluation(Request $request)
    {
        $request->validate([
            'date_evaluated' => 'required|date',
            'evaluation' => 'required|string',
            'kpi_id' => 'required|exists:kpis,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $kpi = Kpi::findOrFail($request->input('kpi_id'));
        $employee = Employee::findOrFail($request->input('employee_id'));

        $evaluations = new Evaluation([
            'date_evaluated' => $request->input('date_evaluated'),
            'evaluation' => $request->input('evaluation'),
        ]);

        $kpi->evaluations()->save($evaluations);
        $employee->evaluations()->save($evaluations);

        return response()->json([
            'message' => 'Evaluation created successfully!',
            'data' => $evaluations,
        ], 201);
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
        try {
            // find the evaluation record
            $evaluations = Evaluation::findOrFail($id);

            // update the evaluation details
            $evaluations->date_evaluated = $request->input('date_evaluated');
            $evaluations->evaluations = $request->input('evaluation');

            // find and assign the associated employee and kpi
            $employee_id = $request->input('employee_id');
            $employee = Employee::findOrFail($employee_id);
            $evaluations->employee()->associate($employee);

            $kpi_id = $request->input('kpi_id');
            $kpi = KPI::findOrFail($kpi_id);
            $evaluations->kpi()->associate($kpi);

            $evaluations->save();

            return response()->json([
                'message' => 'Evaluation updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Evaluation update failed',
                'message' => $e->getMessage()
            ], 500);
        }
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
            $evaluations = Evaluation::findOrFail($id);
            $employee = $evaluations->employee;
            $kpi = $evaluations->kpi;

            return response()->json([
                'evaluation' => $evaluations,
                'employee' => $employee,
                'kpi' => $kpi
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Evaluation retrieval failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}