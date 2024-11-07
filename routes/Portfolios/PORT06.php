<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT06CategoryController;
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
    Route::resource($route.'/section', PORT06CategoryController::class)->names('admin.'.$routeName.'.section')->parameters(['section' => 'PORT06PortfoliosSection']);
//
    Route::resource($route.'/gallries', PORT06CategoryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['gallries' => 'PORT06PortfoliosGallery']);
    Route::post($route.'/gallries/delete', [PORT06CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/gallries/sorting', [PORT06CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');
});
// CLIENT
Route::get($route.'/teste', [PORT06CategoryController::class, 'page'])->name($routeName.'.page');
