<?php

Route::prefix('news/')->group(function () {
    Route::get('/', 'NewsController@index');
    Route::get('/{news}', 'NewsController@view');
});
