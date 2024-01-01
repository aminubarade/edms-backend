<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\DocumentManagement\app\Http\Controllers\DocumentController;
use Modules\DocumentManagement\app\Http\Controllers\DocumentRequestController;
use Modules\DocumentManagement\app\Http\Controllers\FolderController;
use Modules\UserManagement\app\Http\Controllers\CommentController;



Route::group(['middleware' => 'auth:api'], function() {
    Route::prefix('documents')->group(function () {
        Route::get('/', [DocumentController::class, 'getDocuments']);
        Route::get('/view/{document:slug}', [DocumentController::class, 'viewDocument']);
        Route::post('/save', [DocumentController::class, 'saveDocument']);
        Route::put('/update/{document:slug}', [DocumentController::class, 'updateDocument']);
        Route::patch('/update-status/{document:slug}', [DocumentController::class, 'completeDocument']);
        Route::delete('/delete/{document:slug}', [DocumentController::class, 'deleteDocument']);
        Route::post('/add-to-task/{document:slug}', [DocumentController::class, 'addDocumentToTask']);
        Route::post('/move-to-folder/{document:slug}', [DocumentController::class, 'moveDocumentToFolder']);
        Route::get('/{document:slug}/comments/view-all', [CommentController::class, 'getDocumentComments']);
    
        Route::prefix('requests')->group(function () {
            Route::get('/', [DocumentRequestController::class, 'getDocumentRequests']);
            Route::post('/send', [DocumentRequestController::class, 'sendDocumentRequest']);
            Route::patch('/process/{id}', [DocumentRequestController::class, 'processDocumentRequest']);
            Route::patch('/view/{documentrequest:slug}', [DocumentRequestController::class, 'processDocumentRequest']);
            Route::patch('approve-send',[DocumentRequestController::class, 'approveSendDocumentRequest']);
        });

        Route::prefix('files')->group(function () {
            Route::post('/upload-file/{id}', [DocumentController::class, 'attachFileToDocument']);
        });
    
    });

    Route::prefix('folders')->group(function () {
        Route::get('/{department:slug}/view-all', [FolderController::class, 'getDeptFolders']);
        Route::get('/view/{folder:slug}/', [FolderController::class, 'viewFolder']);
        Route::post('/create-folder', [FolderController::class, 'createFolder']);
        Route::put('/update/{folder:slug}', [FolderController::class, 'updateFolder']);
    });
    
    Route::prefix('files')->group(function () {
        Route::post('/upload-file/{id}', [DocumentController::class, 'attachFileToDocument']);
    });



});

