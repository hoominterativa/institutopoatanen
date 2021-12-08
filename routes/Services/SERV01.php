<?php

use Illuminate\Support\Str;
use App\Http\Controllers\Services\SERV01SectionController;
use App\Http\Controllers\Services\SERV01CategoriesController;
use App\Http\Controllers\Services\SERV01Controller;
use App\Http\Controllers\Services\SERV01SubcategoriesController;

Route::prefix('painel')->middleware('auth')->group(function (){
    Route::resource('servico-categoria', SERV01CategoriesController::class)->names('admin.serv01.category')->parameters(['servico-categoria' => 'SERV01ServicesCategories']);
    Route::post('servico-categoria/delete', [SERV01CategoriesController::class, 'destroySelected'])->name('admin.serv01.category.destroySelected');
    Route::post('servico-categoria/sorting', [SERV01CategoriesController::class, 'sorting'])->name('admin.serv01.category.sorting');

    Route::resource('servico-subcategoria', SERV01SubcategoriesController::class)->names('admin.serv01.subcategory')->parameters(['servico-subcategoria' => 'SERV01ServicesSubcategories']);
    Route::post('servico-subcategoria/delete', [SERV01SubcategoriesController::class, 'destroySelected'])->name('admin.serv01.subcategory.destroySelected');
    Route::post('servico-subcategoria/sorting', [SERV01SubcategoriesController::class, 'sorting'])->name('admin.serv01.subcategory.sorting');

    Route::resource('painel/SERV01SectionServices', SERV01SectionController::class)->names('admin.serv01section')->parameters(['SERV01SectionServices'=>'SERV01SectionServices']);
});

// CLIENT
Route::get('servicos/categoria/{SERV01ServicesCategories}', [SERV01Controller::class, 'page'])->name('serv01.category.page');
Route::get('servicos/{SERV01ServicesCategories}/{SERV01ServicesSubcategories}', [SERV01Controller::class, 'page'])->name('serv01.subcategory.page');
Route::get('servicos/{SERV01ServicesCategories}/{SERV01ServicesSubcategories}/{SERV01Services}', [SERV01Controller::class, 'show'])->name('serv01.service.show');

