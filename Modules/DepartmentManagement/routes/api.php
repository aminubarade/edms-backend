<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\DepartmentManagement\app\Http\Controllers\DepartmentController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('departmentmanagement', fn (Request $request) => $request->user())->name('departmentmanagement');
});


Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class,'getAllDepartments']);
    Route::post('/create', [DepartmentController::class,'createDepartment']);
    Route::put('{update/department:slug}/', [DepartmentController::class,'updateDepartment']);
    Route::get('/{department:slug}/users', [DepartmentController::class,'getDepartmentUsers']);
    Route::get('/{department:slug}/folders', [DepartmentController::class,'getDepartmentFolders']);
    Route::get('/{department:slug}/appointments', [DepartmentController::class,'getDepartmentAppointments']);
    Route::get('/{department:slug}/documents', [DepartmentController::class,'getDepartmentDocuments']);
});
