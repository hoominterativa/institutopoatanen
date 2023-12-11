<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT03Controller;
use App\Http\Controllers\Portfolios\PORT03SectionController;
use App\Http\Controllers\Portfolios\PORT03CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Portfolios';
$model = 'PORT03';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Categories
    Route::resource($route.'/categorias', PORT03CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT03PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [PORT03CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PORT03CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
    //Section
    Route::resource($route.'/secao', PORT03SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'PORT03PortfoliosSection']);
});
// CLIENT
Route::get($route.'/categoria/{PORT03PortfoliosCategory:slug}', [PORT03Controller::class, 'page'])->name($routeName.'.category.page');
