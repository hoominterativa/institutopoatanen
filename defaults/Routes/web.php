<?php
// ADMIN
Route::group(['prefix' => 'painel', 'middleware' => 'auth:user'], function () {
    Route::resource('testes', 'Test\TEST01Controller')->names('admin.test01')->parameters(['testes' => 'test01']);
    Route::post('testes/delete', 'Test\TEST01Controller@destroySelected')->name('admin.test01.destroySelected');
});
// CLIENT
Route::get('/testes', 'Test\TEST01Controller@page')->name('test01.page');
Route::get('/testes/{test01}', 'Test\TEST01Controller@show')->name('test01.show');
