<?php

Route::prefix('news/')->group(function () {
    Route::post('create', 'NewsController@create')->middleware('source.site');
    Route::delete('delete', 'NewsController@delete')->middleware('source.site');
    Route::post('/update-picture', 'NewsController@updatePicture')->middleware('source.site');
    Route::post('/update', 'NewsController@update')->middleware('source.site');
});
