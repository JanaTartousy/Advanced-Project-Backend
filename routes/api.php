<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Post("/kpi", [KPIController::class, "AddKpi"]);
Route::Get("/kpi/{id}", [KPIController::class, "getKpi"]);
Route::Delete("/kpi/{id}", [KPIController::class, "deleteKpi"]);
Route::Patch("/kpi/{id}", [KPIController::class, "editKpi"]);