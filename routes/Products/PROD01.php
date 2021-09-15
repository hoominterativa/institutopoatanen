<?php

use App\Http\Controllers\Products\PROD01Controller;

// ADMIN
Route::group(['prefix' => 'painel', 'middleware' => 'auth:user'], function () {
    Route::resource('produtos', PROD01Controller::class)->names('admin.prod01')->parameters(['produtos' => 'prod01']);
    Route::post('produtos/delete', [PROD01Controller::class, 'destroySelected'])->name('admin.prod01.destroySelected');
});
// CLIENT
Route::get('/produtos', [PROD01Controller::class, 'page'])->name('prod01.page');
Route::get('/produtos/{prod01}', [PROD01Controller::class, 'show'])->name('prod01.show');
