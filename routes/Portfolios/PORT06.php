<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT06CategoryController;
use App\Http\Controllers\Portfolios\PORT06SectionController;
use App\Http\Controllers\Portfolios\PORT06GalleryController;
/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

 $module = 'Portfolios';
 $model = 'PORT06';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', PORT06CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT06PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [PORT06CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PORT06CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
    //
    Route::resource($route.'/section', PORT06SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['section' => 'PORT06PortfoliosSection']);
    Route::PUT($route.'/banner/Update', [PORT06SectionController::class, 'updateBanner'])->name('admin.'.$routeName.'.section.Bannerupdate');
    Route::PUT($route.'/banner/Store', [PORT06SectionController::class, 'storeBanner'])->name('admin.'.$routeName.'.section.Bannerstore');

//
    Route::resource($route.'/gallries', PORT06GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['gallries' => 'PORT06PortfoliosGallery']);
    Route::post($route.'/gallries/delete', [PORT06GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/gallries/sorting', [PORT06GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');
});
// CLIENT
Route::get($route.'/teste', [PORT06CategoryController::class, 'page'])->name($routeName.'.page');
