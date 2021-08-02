<?php
// ADMIN
// 'middleware' => 'auth:user'
Route::group(['prefix' => 'painel'], function () {
    Route::resource('topicos', 'Topics\TOPI01Controller')->names('photos', 'photos')->parameters(['topicos' => 'topics']);
});
// CLIENT
Route::get('/topicos', 'Topics\TOPI01Controller@page')->name('photos.page');
Route::get('/topicos/{topics}', 'Topics\TOPI01Controller@show')->name('photos.show');
