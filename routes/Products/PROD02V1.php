<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\PROD02V1Controller;
use App\Http\Controllers\Products\PROD02V1BannerController;
use App\Http\Controllers\Products\PROD02V1GalleryController;
use App\Http\Controllers\Products\PROD02V1SectionController;
use App\Http\Controllers\Products\PROD02V1CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Products';
$model = 'PROD02V1';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', PROD02V1CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PROD02V1ProductsCategory']);
    Route::post($route.'/categoria/delete', [PROD02V1CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PROD02V1CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/galeria', PROD02V1GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'PROD02V1ProductsGallery']);
    Route::post($route.'/galeria/delete', [PROD02V1GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [PROD02V1GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    Route::resource($route.'/banner', PROD02V1BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'PROD02V1ProductsBanner']);
    Route::resource($route.'/section', PROD02V1SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['section' => 'PROD02V1ProductsSection']);
});
// // CLIENT
Route::get($route.'/categoria/{PROD02V1ProductsCategory:slug}', [PROD02V1Controller::class, 'page'])->name($routeName.'.category.page');
