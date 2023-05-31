<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\PROD02Controller;
use App\Http\Controllers\Products\PROD02BannerController;
use App\Http\Controllers\Products\PROD02GalleryController;
use App\Http\Controllers\Products\PROD02SectionController;
use App\Http\Controllers\Products\PROD02CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Products';
$model = 'PROD02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', PROD02CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PROD02ProductsCategory']);
    Route::post($route.'/categoria/delete', [PROD02CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PROD02CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/galeria', PROD02GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'PROD02ProductsGallery']);
    Route::post($route.'/galeria/delete', [PROD02GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [PROD02GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    Route::resource($route.'/banner', PROD02BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'PROD02ProductsBanner']);
    Route::resource($route.'/section', PROD02SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['section' => 'PROD02ProductsSection']);
});
// // CLIENT
Route::get($route.'/categoria/{PROD02ProductsCategory:slug}', [PROD02Controller::class, 'page'])->name($routeName.'.category.page');
