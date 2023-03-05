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
        if($name=$request->query('search')){
        $kpi = Kpi::where('name', 'LIKE', '%' . $name . '%')->paginate($perPage ?: 20);;

        if (!$kpi) {
            return response()->json(['message' => 'Kpi not found'], 404);
        }
        return response()->json([
            'message' => 'kpi retrive successfully',
            'kpis' => $kpi,
        ]);
    }
    $kpis = Kpi::paginate($perPage ?: 20);

        return response()->json([
            'message' => 'Kpis retrieved successfully',
            'kpis' => $kpis,
        ]);
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