<?php

use App\Http\Controllers\Products\PROD02Controller;

// ADMIN
Route::group(['prefix' => 'painel', 'middleware' => 'auth:user'], function () {
    Route::resource('artigos', PROD02Controller::class)->names('admin.prod02')->parameters(['artigos' => 'prod02']);
    Route::post('artigos/delete', [PROD02Controller::class, 'destroySelected'])->name('admin.prod02.destroySelected');
});
// CLIENT
Route::get('/artigos', [PROD02Controller::class, 'page'])->name('prod02.page');
Route::get('/artigos/{prod02}', [PROD02Controller::class, 'show'])->name('prod02.show');
