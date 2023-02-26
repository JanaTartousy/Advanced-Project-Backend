<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpi;

class KpiController extends Controller
{
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

public function getAll()
{
    try {
        $kpis = Kpi::all();
        return response()->json($kpis, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to retrieve KPIs.'], 500);
    }
}

    public function getKpi(Request $request, $id){

    $kpi =  Kpi::where("id",$id)->get();

    return response()->json([
        'kpi' => $kpi
    ]);

}

    public function editKpi(Request $request, $id){

        $kpi =  Kpi::find($id);
        $inputs = $request;
        $kpi->update($inputs);

        return response()->json([
            'message' => "Kpi edited successfully!",
             'kpi' => $kpi,
        ]);

    }

    public function deleteKpi(Request $request, $id){

        $kpi =  Kpi::find($id);
        $kpi->delete();
        return response()->json([
            'message' => "Kpi deleted successfully!"
        ]);
    
}

    public function evaluations(Kpi $kpi)
{
    $evaluations = $kpi->evaluations;
    
    return response()->json([
        'evaluations' => $evaluations
    ]);
}

}