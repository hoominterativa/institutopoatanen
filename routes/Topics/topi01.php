<?php
// ADMIN
// 'middleware' => 'auth:user'
Route::group(['prefix' => 'painel'], function () {
    Route::resource('topicos', 'Topics\TOPI01Controller')->names('topi01')->parameters(['topicos' => 'topi01']);
});
// CLIENT
Route::get('/topicos', 'Topics\TOPI01Controller@page')->name('topi01.page');
Route::get('/topicos/{topics}', 'Topics\TOPI01Controller@show')->name('topi01.show');
