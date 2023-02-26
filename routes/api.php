<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KPIController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
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

Route::Post('/kpi', [KPIController::class, 'AddKpi']);
Route::Get('/kpi', [KPIController::class, 'getAll']);
Route::Get('/kpi/{id}', [KPIController::class, 'getKpi']);
Route::Delete('/kpi/{id}', [KPIController::class, 'deleteKpi']);
Route::Patch('/kpi/{id}', [KPIController::class, 'editKpi']);


Route::post('/projects', [ProjectController::class, 'store']);


Route::post('/employees', [EmployeeController::class, 'store']);

Route::get('/roles', [RoleController::class, 'getRoles']);
Route::get('/roles/{id}', [RoleController::class, 'getRole']);
Route::post('/roles', [RoleController::class, 'store']);
Route::patch('/roles/{id}', [\App\Http\Controllers\RoleController::class, 'update']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);


Route::Post('/admin', [AdminController::class, 'addAdmin']);
Route::Post('/login', [AdminController::class, 'login']);
Route::Get('/logout', [AdminController::class, 'logout']);
Route::Patch('/admin/{id}', [AdminController::class, 'editAdmin']);
Route::delete('/admin/{id}', [AdminController::class, 'deleteAdmin']);
Route::Get('/admin', [AdminController::class, 'getAllAdmins']);
Route::Get('/admin/{id}', [AdminController::class, 'getAdminByID']);


Route::Post('/report', [ReportController::class, 'addReport']);
Route::Get('/report/{id}', [ReportController::class, 'getReportByID']);
Route::Get('/report', [ReportController::class, 'getAllReports']);
Route::Post('/report', [ReportController::class, 'addReport']);
Route::Delete('/report', [ReportController::class, 'deleteReport']);
