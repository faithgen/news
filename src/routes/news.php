<?php

Route::prefix('news/')->group(function () {
    Route::get('/', 'NewsController@index');
    Route::get('/{news}', 'NewsController@view');
    Route::post('create', 'NewsController@create');
    Route::delete('delete', 'NewsController@delete');
    Route::post('/update-picture', 'NewsController@updatePicture');
    Route::post('/update', 'NewsController@update');
});
