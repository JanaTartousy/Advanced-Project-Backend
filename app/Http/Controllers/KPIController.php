<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KPI;

class KPIController extends Controller
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

    public function getKpi(Request $request, $id){

    $kpi =  Kpi::find($id)->get();

    return response()->json([
        'message' => $kpi
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
}