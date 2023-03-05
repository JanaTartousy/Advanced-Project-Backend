<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpi;

class KpiController extends Controller
{

     /**
     * Add a newly created kpi in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function AddKpi(Request $request){

    $kpi = new Kpi;
    $name = $request->input('name');
    $description = $request->input('description');
    $kpi->name = $name;
    $kpi->description = $description;
    $kpi->save();

    return response()->json([
        'message' => "Kpi created successfully!"
    ]);
}

 /**
     * Display a listing of the kpis.
     *
     * @return JsonResponse
     */
public function getAll(Request $request)
{   
    $pageNumber=$request->query("page");
    $perPage=$request->query("per_page");

    try {
        $kpis = Kpi::paginate($perPage?:2, ['*'], 'page', $pageNumber);
        return response()->json($kpis, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to retrieve KPIs.'], 500);
    }
}


     /**
     * Display the specified kpi.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function getKpi(Request $request, $id){

    $kpi =  Kpi::where("id",$id)->get();

    return response()->json([
        'kpi' => $kpi
    ]);

}

    // public function editKpi(Request $request, $id){


    //     $kpi =  Kpi::find($id);
    //     $inputs = $request;
    //     $kpi->update($inputs);

    //     return response()->json([
    //         'message' => "Kpi edited successfully!",
    //          'kpi' => $kpi,
    //     ]);

    // }

      /**
     * Update the specified kpi in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function editKpi(Request $request, $id) {
        try {
            $kpi = kpi::find($id);
            $inputs = $request->except("_method");
            $kpi->update($inputs);

            return response()->json([
                "message" => $kpi
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "message" => $e
            ]);
        }
    }
    
    /**
     * Remove the specified kpi from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function deleteKpi(Request $request, $id){

        $kpi =  Kpi::find($id);
        $kpi->delete();
        return response()->json([
            'message' => "Kpi deleted successfully!"
        ]);
    
}

    public function evaluation(Kpi $kpi)
{
    $evaluations = $kpi->evaluation;
    
    return response()->json([
        'evaluations' => $evaluations
    ]);
}

}