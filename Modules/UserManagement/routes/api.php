<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\UserManagement\app\Http\Controllers\UserManagementController;
use Modules\TaskManagement\app\Http\Controllers\TaskController;
use Modules\UserManagement\app\Http\Controllers\CommentController;
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
    Route::get('/view-all', [UserManagementController::class, 'getUsers']);
    Route::get('/view-user/{user:username}', [UserManagementController::class, 'viewUser']);
    Route::post('/save-user', [UserManagementController::class, 'saveUser']);
    Route::put('update-user/{user:username}', [UserManagementController::class, 'updateUser']);
    Route::delete('/delete-user/{user:username}', [UserManagementController::class, 'destroy']);
    Route::get('/{user:username}/comments/view-all', [CommentController::class, 'getUserComments']);
    Route::post('/assign-tasks', [UserManagementController::class, 'assignTaskToUser']);
});

    

Route::prefix('comments')->group(function () {
    Route::get('/view-all', [CommentController::class, 'getComments']);
    Route::post('/add-comment', [CommentController::class, 'addComment']);
});