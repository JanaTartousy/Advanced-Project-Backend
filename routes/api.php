<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeRoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamController;
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

Route::middleware('auth:')->get('/user',[UserController::class, 'getAllUsers'] );
// Route::get('/user', [UserController::class, 'getAllUsers']);

Route::post('/kpi', [KpiController::class, 'AddKpi']);
Route::get('/kpi', [KpiController::class, 'getAll']);
Route::get('/kpi/{id}', [KpiController::class, 'getKpi']);
Route::delete('/kpi/{id}', [KpiController::class, 'deleteKpi']);
Route::patch('/kpi/{id}', [KpiController::class, 'editKpi']);

// Route::Post('/kpi', [KPIController::class, 'AddKpi']);
// Route::Get('/kpi', [KPIController::class, 'getAll']);
// Route::Get('/kpi/{id}', [KPIController::class, 'getKpi']);
// Route::Delete('/kpi/{id}', [KPIController::class, 'deleteKpi']);
// Route::Patch('/kpi/{id}', [KPIController::class, 'editKpi']);



Route::get('/projects', [ProjectController::class, 'getProjects']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects/{id}', [ProjectController::class, 'getProject']);
Route::patch('/projects/{id}', [ProjectController::class, 'update']);
Route::post('/projects/{id}', [ProjectController::class, 'destroy']);

Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees', [EmployeeController::class, 'getEmployees']);
Route::get('/employees/{id}', [EmployeeController::class, 'getEmployee']);
Route::patch('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);

Route::get('/roles', [RoleController::class, 'getRoles']);
Route::get('/roles/{id}', [RoleController::class, 'getRole']);
Route::post('/roles', [RoleController::class, 'store']);
Route::patch('/roles/{id}', [RoleController::class, 'update']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

// Route::Post('/user', [UserController::class, 'addUser']);
// Route::Post('/login', [UserController::class, 'login'])->name('login');;
// Route::Get('/logout', [UserController::class, 'logout']);
// Route::Patch('/user/{id}', [UserController::class, 'editUser']);
// Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
// Route::Get('/user/{id}', [UserController::class, 'getUserByID']);

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'
// ], function ($router) {

// Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [UserController::class, 'logout']);
// });

Route::Post('/report', [ReportController::class, 'addReport']);
Route::Get('/report/{id}', [ReportController::class, 'getReportByID']);
Route::Get('/report', [ReportController::class, 'getAllReports']);
Route::Post('/report', [ReportController::class, 'addReport']);
Route::Delete('/report', [ReportController::class, 'deleteReport']);

Route::get('/teams', [TeamController::class, 'getTeams']);
Route::get('/teams/{id}', [TeamController::class, 'getTeam']);
Route::post('/teams', [TeamController::class, 'store']);
Route::patch('/teams/{id}', [TeamController::class, 'update']);
Route::delete('/teams/{id}', [TeamController::class, 'destroy']);

Route::get('/employeerole', [EmployeeRoleController::class, 'get']);
Route::get('/employeerole/{id}', [EmployeeRoleController::class, 'destroy']);
Route::patch('/employeerole/{id}', [EmployeeRoleController::class, 'destroy']);
Route::post('/employeerole', [EmployeeRoleController::class, 'assignRole']);
Route::delete('/employeerole/{id}', [EmployeeRoleController::class, 'destroy']);

Route::Post('/evaluations', [EvaluationController::class, 'AddEvaluation']);
Route::Get('/evaluations', [EvaluationController::class, 'getAllEvaluations']);
Route::Get('/evaluations/{id}', [EvaluationController::class, 'getEvaluationById']);
Route::Patch('/evaluations/{id}', [EvaluationController::class, 'updateEvaluation']);
Route::Delete('/evaluations/{id}', [EvaluationController::class, 'deleteEvaluation']);
