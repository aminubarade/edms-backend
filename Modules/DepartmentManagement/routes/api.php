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
    Route::post('/create', [DepartmentController::class,'createDepartment']);
    Route::get('/{department:slug}/users', [DepartmentController::class,'getDepartmentUsers']);
});
