<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\UserManagement\app\Http\Controllers\UserManagementController;
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

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('usermanagement', fn (Request $request) => $request->user())->name('usermanagement');
// });


Route::group(['middleware' => 'auth:api'], function() {








    
});


Route::prefix('users')->group(function () {
    Route::get('/view-all', [UserManagementController::class, 'index']);
    Route::get('/view-user/{user:username}', [UserManagementController::class, 'show']);
    Route::post('/save-user', [UserManagementController::class, 'store']);
    Route::put('update-user/{user:username}', [UserManagementController::class, 'update']);
    Route::delete('/delete-user/{user:username}', [UserManagementController::class, 'destroy']);
    Route::post('/assign-task', [UserManagementController::class, 'assignTask']);
});