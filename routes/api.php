<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;

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

Route::post('/projects', [ProjectController::class, 'store']);

Route::post('/employees', [EmployeeController::class, 'store']);




Route::post('/roles', [RoleController::class, 'store']);
Route::put('/roles/{id}', [\App\Http\Controllers\RoleController::class, 'update']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
