<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\DocumentManagement\app\Http\Controllers\DocumentController;

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
    Route::get('settings', fn (Request $request) => $request->user())->name('settings');
});

Route::prefix('settings')->group(function () {

    Route::prefix('ranks')->group(function () {
        Route::post('create', [RankController::class, 'createRank']);
        Route::get('view-all', [RankController::class, 'getAllRanks']);
        Route::put('/update/{rank:title}/', [RankController::class, 'updateRank']);
        Route::delete('delete/{rank:title}', [RankController::class, 'getAllRanks']);
    });

    Route::prefix('document-class')->group(function () {
        Route::post('create', [DocumentClassController::class, 'createDocumentClass']);
        Route::get('view-all', [DocumentClassController::class, 'getAllDocumentClass']);
        Route::put('/update/{document-class:title}/', [DocumentClassController::class, 'updateDocumentClass']);
        Route::delete('delete/{document-class:title}', [DocumentClassController::class, 'deleteDocumentClass']);
    });

    Route::prefix('document-type')->group(function () {
        Route::post('create', [DocumentTypeController::class, 'createDocumentType']);
        Route::get('view-all', [DocumentTypeController::class, 'getAllDocumentType']);
        Route::put('/update/{rank:title}/', [DocumentTypeController::class, 'updateDocumentType']);
        Route::delete('delete/{rank:title}', [DocumentTypeController::class, 'deleteDocumentType']);
    });

    Route::prefix('branch')->group(function () {
        Route::post('create', [BranchController::class, 'createBranch']);
        Route::get('view-all', [BranchController::class, 'getAllBranches']);
        Route::put('/update/{branch:title}/', [BranchController::class, 'updateBranch']);
        Route::delete('delete/{branch:title}', [BranchController::class, 'deleteBranch']);
    });

    Route::prefix('specialization')->group(function () {
        Route::post('create', [SpecializationController::class, 'createRank']);
        Route::get('view-all', [SpecializationController::class, 'getAllRanks']);
        Route::put('/update/{specialization:title}/', [SpecializationController::class, 'updateSpecialization']);
        Route::delete('delete/{specialization:title}', [SpecializationController::class, 'deleteSpecialization']);
    });

    Route::prefix('common-comments')->group(function () {
        Route::post('create', [CommonCommentController::class, 'createComment']);
        Route::get('view-all', [CommonCommentController::class, 'getAllCommonComments']);
        Route::put('/update/{common-comments:title}/', [CommonCommentController::class, 'updateCommonComment']);
        Route::delete('delete/{common-comments:title}', [CommonCommentController::class, 'deleteCommonComment']);
    });



});