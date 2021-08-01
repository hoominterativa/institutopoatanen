<?php
// ADMIN
Route::group(['prefix' => 'painel', 'middleware' => 'auth:user'], function () {
    Route::resource('photos', 'Topics\TOPI01Controller')->names('photos', 'photos');
});
// CLIENT
Route::get('/photos', 'Topics\TOPI01Controller@page')->name('photos.page');
Route::get('/photos/{photos}', 'Topics\TOPI01Controller@show')->name('photos.show');
