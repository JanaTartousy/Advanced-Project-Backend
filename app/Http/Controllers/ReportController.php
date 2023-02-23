<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function addReport(Request $request){
        $report = new Report();
        $file = $request->input('file');
        $report->file = $file;
        $report->save();

        return response()->json([
            'message' => 'Report added successfully'
        ]);
    }
    public function getAllReports(Request $request){
        $reports = Report::all();
        return response()->json([
            'message' => $reports,
        ]);
    }

    public function getReportByID(Request $request, $id){

        $report =  Report::find($id);

        return response()->json([
            'message' => $report,
        ]); 
    }

    public function deleteReport(Request $request, $id){
         $report =  Report::find($id);
         $report->delete();
         return response()->json([
           'message' => 'Report deleted successfully'
        ]);
    }
    
}
