<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{   
     /**
     * Add a newly created report in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function addReport(Request $request){
        $report = new Report();
        $file = $request->input('file');
        $report->file = $file;
        $report->save();

        return response()->json([
            'message' => 'Report added successfully'
        ]);
    } 

     /**
     * Display a listing of the reports.
     *
     * @return JsonResponse
     */ 

    public function getAllReports(){
        $reports = Report::all();
        return response()->json([
            'message' => $reports,
        ]);
    }
    
    /**
     * Display the specified report.
     *
     * @param  int  $id
     * @return JsonResponse
     */ 

    public function getReportByID($id){

        $report =  Report::find($id);

        return response()->json([
            'message' => $report,
        ]); 
    }
    
      /**
     * Remove the specified report from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */

    public function deleteReport($id){
         $report =  Report::find($id);
         $report->delete();
         return response()->json([
           'message' => 'Report deleted successfully'
        ]);
    }
    
}
