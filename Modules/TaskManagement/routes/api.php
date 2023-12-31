<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('taskmanagement', fn (Request $request) => $request->user())->name('taskmanagement');
});


//use prefix
Route::group(['middleware' => 'auth:api'], function() {

    Route::prefix('tasks')->group(function () {
        Route::get('/view-all', [TaskController::class, 'getTasks']);
        Route::get('/view-task/{task:slug}', [TaskController::class, 'viewTask']);
        Route::get('/view-user-tasks/{user:username}', [TaskController::class, 'getUserTasks']);
        Route::get('/view-task-users/{task:slug}', [TaskController::class, 'getTaskUsers']);
        Route::post('/save-task', [TaskController::class, 'storeTask']);
        Route::put('/update-task/{task:slug}', [TaskController::class, 'updateTask']);
        Route::delete('/delete-task/{task:slug}', [TaskController::class, 'deleteTask']);
        Route::post('/assign', [TaskController::class, 'store']);
        Route::get('/{task:slug}/comments/view-all', [CommentController::class, 'getTaskComments']);
        
    });

});
