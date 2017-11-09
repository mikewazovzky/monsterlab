<?php

Route::group(['middleware' => ['web']], function () {
    Route::post('/favorites/{model}/{id}', 'App\Http\Controllers\FavoritesController@store')->name('favorites.store');
    Route::delete('/favorites/{model}/{id}', 'App\Http\Controllers\FavoritesController@destroy')->name('favorites.destroy');
});
