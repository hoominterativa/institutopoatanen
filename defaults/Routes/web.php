<?php

use App\Http\Controllers\TEST01Controller;

// ADMIN
Route::group(['prefix' => 'painel', 'middleware' => 'auth:user'], function () {
    Route::resource('testes', TEST01Controller::class)->names('admin.test01')->parameters(['testes' => 'test01']);
    Route::post('testes/delete', [TEST01Controller::class, 'destroySelected'])->name('admin.test01.destroySelected');
    Route::post('testes/sorting', [TEST01Controller::class, 'sorting'])->name('admin.test01.sorting');
});
// CLIENT
Route::get('/testes', [TEST01Controller::class, 'page'])->name('test01.page');
Route::get('/testes/{test01}', [TEST01Controller::class, 'show'])->name('test01.show');
