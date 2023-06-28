<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\PROD05SectionController;
use App\Http\Controllers\Products\PROD05CategoryController;
use App\Http\Controllers\Products\PROD05SubcategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Products';
$model = 'PROD05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', PROD05CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PROD05ProductsCategory']);
    Route::post($route.'/categoria/delete', [PROD05CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PROD05CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/subcategorias', PROD05SubcategoryController::class)->names('admin.'.$routeName.'.subcategory')->parameters(['subcategorias' => 'PROD05ProductsSubcategory']);
    Route::post($route.'/subcategoria/delete', [PROD05SubcategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.subcategory.destroySelected');
    Route::post($route.'/subcategoria/sorting', [PROD05SubcategoryController::class, 'sorting'])->name('admin.'.$routeName.'.subcategory.sorting');

    Route::resource($route.'/section', PROD05SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['section' => 'PROD05ProductsSection']);
});
// CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
