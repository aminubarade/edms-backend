<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Settings\app\Http\Controllers\DocumentClassController;
use Modules\Settings\app\Http\Controllers\DocumentTypeController;
use Modules\Settings\app\Http\Controllers\BranchController;
use Modules\Settings\app\Http\Controllers\SpecializationController;
use Modules\Settings\app\Http\Controllers\RankController;
use Modules\Settings\app\Http\Controllers\CommonCommentController;
use Modules\Settings\app\Http\Controllers\ReligionController;

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
//     Route::get('settings', fn (Request $request) => $request->user())->name('settings');
// });

Route::prefix('settings')->group(function () {

    Route::prefix('ranks')->group(function () {
        Route::post('create', [RankController::class, 'createRank']);
        Route::get('view-all', [RankController::class, 'getAllRanks']);
        Route::put('/update/{rank:slug}/', [RankController::class, 'updateRank']);
        Route::delete('delete/{rank:slug}', [RankController::class, 'deleteRank']);
    });

    Route::prefix('document-class')->group(function () {
        Route::post('create', [DocumentClassController::class, 'createDocumentClass']);
        Route::get('view-all', [DocumentClassController::class, 'getAllDocumentClasses']);
        Route::put('/update/{document-class:slug}/', [DocumentClassController::class, 'updateDocumentClass']);
        Route::delete('delete/{document-class:slug}', [DocumentClassController::class, 'deleteDocumentClass']);
    });

    Route::prefix('document-type')->group(function () {
        Route::post('create', [DocumentTypeController::class, 'createDocumentType']);
        Route::get('view-all', [DocumentTypeController::class, 'getAllDocumentTypes']);
        Route::put('/update/{documentType:slug}/', [DocumentTypeController::class, 'updateDocumentType']);
        Route::delete('delete/{documentType:slug}', [DocumentTypeController::class, 'deleteDocumentType']);
    });

    Route::prefix('branches')->group(function () {
        Route::post('create', [BranchController::class, 'createBranch']);
        Route::get('view-all', [BranchController::class, 'getAllBranches']);
        Route::put('/update/{branch:slug}/', [BranchController::class, 'updateBranch']);
        Route::delete('delete/{branch:slug}', [BranchController::class, 'deleteBranch']);
    });

    Route::prefix('specializations')->group(function () {
        Route::post('create', [SpecializationController::class, 'createSpecialization']);
        Route::get('view-all', [SpecializationController::class, 'getAllSpecializations']);
        Route::put('/update/{specialization:slug}/', [SpecializationController::class, 'updateSpecialization']);
        Route::delete('delete/{specialization:slug}', [SpecializationController::class, 'deleteSpecialization']);
    });

    Route::prefix('common-comments')->group(function () {
        Route::post('create', [CommonCommentController::class, 'createCommonComment']);
        Route::get('view-all', [CommonCommentController::class, 'getAllCommonComments']);
        Route::put('/update/{commonComment:slug}/', [CommonCommentController::class, 'updateCommonComment']);
        Route::delete('delete/{commonComment:slug}', [CommonCommentController::class, 'deleteCommonComment']);
    });

    Route::prefix('religions')->group(function () {
        Route::post('create', [ReligionController::class, 'createReligion']);
        Route::get('view-all', [ReligionController::class, 'getAllReligions']);
        Route::put('/update/{religion:slug}/', [ReligionController::class, 'updateReligion']);
        Route::delete('delete/{religion:slug}', [ReligionController::class, 'deleteReligion']);
    });



});