<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\DocumentManagement\app\Http\Controllers\DocumentController;
use Modules\DocumentManagement\app\Http\Controllers\FolderController;
use Modules\UserManagement\app\Http\Controllers\CommentController;


Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('documentmanagement', fn (Request $request) => $request->user())->name('documentmanagement');
});

Route::prefix('documents')->group(function () {
    Route::get('/view-all', [DocumentController::class, 'getDocuments']);
    Route::get('/view-document/{document:slug}', [DocumentController::class, 'viewDocument']);
    Route::post('/save-document', [DocumentController::class, 'saveDocument']);
    Route::put('/update-document/{document:slug}', [DocumentController::class, 'updateDocument']);
    Route::delete('/delete-dcoument/{document:slug}', [DocumentController::class, 'deleteDocument']);
    Route::post('/assign-to-task', [DocumentController::class, 'assignToTask']);
    Route::post('/move-to-folder', [DocumentController::class, 'moveTaskTo']);
    Route::get('/{document:slug}/comments/view-all', [CommentController::class, 'getDocumentComments']);
});

Route::prefix('folders')->group(function () {
    Route::get('/{department:slug}/view-all', [FolderController::class, 'getDeptFolders']);
    Route::get('/view/{folder:slug}/', [FolderController::class, 'viewFolder']);
    Route::post('/create-folder', [FolderController::class, 'createFolder']);
    Route::put('/update/{folder:slug}', [FolderController::class, 'updateFolder']);
});

Route::prefix('files')->group(function () {

    Route::post('/upload-file', [FolderController::class, 'uploadFile']);




    
});
