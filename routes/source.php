<?php

use FaithGen\News\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::prefix('news/')
    ->middleware('source.site')
    ->group(function () {
        Route::post('', [NewsController::class, 'create']);
        Route::delete('{news}', [NewsController::class, 'delete']);
        Route::post('/update-picture', [NewsController::class, 'updatePicture']);
        Route::post('/update', [NewsController::class, 'update']);
    });
