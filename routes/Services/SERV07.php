<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV07SectionController;
use App\Http\Controllers\Services\SERV07CategoryController;
use App\Http\Controllers\Services\SERV07SectionCategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV07';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Category
    Route::resource($route.'/categorias', SERV07CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV07ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV07CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV07CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    //Section Category
    Route::resource($route.'/secao-categorias', SERV07SectionCategoryController::class)->names('admin.'.$routeName.'.section-category')->parameters(['secao-categorias' => 'SERV07ServicesSectionCategory']);
    Route::post($route.'/secao-categoria/delete', [SERV07SectionCategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.section-category.destroySelected');
    Route::post($route.'/secao-categoria/sorting', [SERV07SectionCategoryController::class, 'sorting'])->name('admin.'.$routeName.'.section-category.sorting');

    //Section
    Route::resource($route.'/secao', SERV07SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV07ServicesSection']);

    //Banner
    Route::resource($route.'/banner', SERV07SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['banner' => 'SERV07ServicesSection']);
});
// CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
