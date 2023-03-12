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
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::middleware(['authorize'])->group(function () {
    //Routes for KPIs
    Route::post('/kpi', [KpiController::class, 'AddKpi']);
    Route::get('/kpi', [KpiController::class, 'getAll']);
    Route::get('/kpi/{id}', [KpiController::class, 'getKpi']);
    Route::delete('/kpi/{id}', [KpiController::class, 'deleteKpi']);
    Route::patch('/user/{id}', [UserController::class, 'editUser']);
    Route::patch('/kpi/{id}', [KpiController::class, 'editKpi']);

    //Routes for users
    Route::get('/user/{id}', [UserController::class, 'getUserByID']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
    Route::get('/user', [UserController::class, 'getAllUsers']);

    //Routes for reports
    Route::Post('/report', [ReportController::class, 'addReport']);
    Route::Get('/report/{id}', [ReportController::class, 'getReportByID']);
    Route::Get('/report', [ReportController::class, 'getAllReports']);
    Route::Post('/report', [ReportController::class, 'addReport']);
    Route::Delete('/report', [ReportController::class, 'deleteReport']);

    //Routes for teams
    Route::get('/teams', [TeamController::class, 'getTeams']);
    Route::get('/teams/{id}', [TeamController::class, 'getTeam']);
    Route::post('/teams', [TeamController::class, 'store']);
    Route::patch('/teams/{id}', [TeamController::class, 'update']);
    Route::delete('/teams/{id}', [TeamController::class, 'destroy']);
    Route::patch('/team/{id}', [EmployeeController::class, 'updateTeamId']);

    //Routes for employeeRoles in a project
    Route::get('/employeerole', [EmployeeRoleController::class, 'get']);
    Route::get('/employeerole/{id}', [EmployeeRoleController::class, 'destroy']);
    Route::patch('/employeerole/{id}', [EmployeeRoleController::class, 'destroy']);
    Route::post('/employeerole', [EmployeeRoleController::class, 'assignRole']);
    Route::delete('/employeerole/{id}', [EmployeeRoleController::class, 'destroy']);

    //Routes for evaluations
    Route::Post('/evaluations', [EvaluationController::class, 'AddEvaluation']);
    Route::Get('/evaluations', [EvaluationController::class, 'getAllEvaluations']);
    Route::Get('/evaluations/{id}', [EvaluationController::class, 'getEvaluationById']);
    Route::Patch('/evaluations/{id}', [EvaluationController::class, 'updateEvaluation']);
    Route::Delete('/evaluations/{id}', [EvaluationController::class, 'deleteEvaluation']);

    //Routes for projects
    Route::get('/projects', [ProjectController::class, 'getProjects']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{id}', [ProjectController::class, 'getProject']);
    Route::patch('/projects/{id}', [ProjectController::class, 'update']);
    Route::post('/projects/{id}', [ProjectController::class, 'destroy']);

    //Routes for employees
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employees', [EmployeeController::class, 'getEmployees']);
    Route::get('/employees/{id}', [EmployeeController::class, 'getEmployee']);
    Route::patch('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);

    //Routes for roles
    Route::get('/roles', [RoleController::class, 'getRoles']);
    Route::get('/roles/{id}', [RoleController::class, 'getRole']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::patch('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
});
