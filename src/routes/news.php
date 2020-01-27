<?php

use FaithGen\News\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::prefix('news/')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/{news}', [NewsController::class, 'view']);
    Route::get('comments/{news}', [NewsController::class, 'comments']);
    Route::post('comment', [NewsController::class, 'comment']);
});
