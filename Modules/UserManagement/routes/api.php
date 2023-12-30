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
    Route::prefix('users')->group(function () {
        Route::get('/', [UserManagementController::class, 'getAllUsers']);
        Route::get('/view/{user:username}', [UserManagementController::class, 'viewUser']);
        Route::post('/save', [UserManagementController::class, 'saveUser']);
        Route::put('/update/{user:username}', [UserManagementController::class, 'updateUser']);
        Route::delete('/delete/{user:username}', [UserManagementController::class, 'deleteUser']);
        Route::post('/assign-tasks', [UserManagementController::class, 'assignTaskToUser']);
        Route::get('/{user:username}/comments/view-all', [CommentController::class, 'getUserComments']);//fetch
    });
    Route::prefix('comments')->group(function () {
        Route::get('/view-all', [CommentController::class, 'getComments']);
        Route::post('/add-comment', [CommentController::class, 'addComment']);
    });
});


Route::prefix('notifications')->group(function () {
    Route::get('/viewAll', [NotificationController::class, 'viewAll']);
    Route::get('/unread', [NotificationController::class, 'unread']);
    Route::get('/getUnreadNotificationsCount', [NotificationController::class, 'getUnreadNotificationsCount']);
    Route::get('/markAsRead/{notificationId}', [NotificationController::class, 'markAsRead']);
    Route::post('/bulkUpdate', [NotificationController::class, 'bulkUpdate']);
});