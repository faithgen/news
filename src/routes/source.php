<?php

use FaithGen\News\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::prefix('news/')->group(function () {
    Route::post('create', [NewsController::class, 'create'])->middleware('source.site');
    Route::delete('delete', [NewsController::class, 'delete'])->middleware('source.site');
    Route::post('/update-picture', [NewsController::class, 'updatePicture'])->middleware('source.site');
    Route::post('/update', [NewsController::class, 'update'])->middleware('source.site');
});
