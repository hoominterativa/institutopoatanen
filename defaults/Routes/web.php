<?php
// ADMIN
Route::group(['prefix' => 'painel', 'middleware' => 'auth:user'], function () {
    Route::resource('photos', 'Topics\TOPI01Controller')->names('admin.photos')->parameters(['photos' => 'photos']);
    Route::post('photos/delete', 'Topics\TOPI01Controller@destroySelected')->name('admin.photos.destroySelected');
});
// CLIENT
Route::get('/photos', 'Topics\TOPI01Controller@page')->name('photos.page');
Route::get('/photos/{photos}', 'Topics\TOPI01Controller@show')->name('photos.show');
