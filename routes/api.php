<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KPIController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EvaluationController;

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
Route::Get("/kpi", [KPIController::class, "getAll"]);
Route::Get("/kpi/{id}", [KPIController::class, "getKpi"]);
Route::Delete("/kpi/{id}", [KPIController::class, "deleteKpi"]);
Route::Patch("/kpi/{id}", [KPIController::class, "editKpi"]);
Route::post('/projects', [ProjectController::class, 'store']);

Route::post('/employees', [EmployeeController::class, 'store']);




Route::post('/roles', [RoleController::class, 'store']);
Route::put('/roles/{id}', [\App\Http\Controllers\RoleController::class, 'update']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

// Route::Post('/evaluation', [EvaluationController::class, 'AddEvaluation']);

Route::Post('/evaluations', [EvaluationController::class, 'AddEvaluation']);
Route::Get('/evaluations', [EvaluationController::class, 'getAllEvaluations']);
Route::Get('/evaluations/{id}', [EvaluationController::class, 'getEvaluationById']);
Route::Patch('/evaluations/{id}', [EvaluationController::class, 'updateEvaluation']);
Route::Delete('/evaluations/{id}', [EvaluationController::class, 'deleteEvaluation']);

