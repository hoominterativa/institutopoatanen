<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV05Controller;
use App\Http\Controllers\Services\SERV05SectionController;
use App\Http\Controllers\Services\SERV05CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', SERV05CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV05ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV05CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV05CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/secao', SERV05SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV05ServicesSection']);
});
// CLIENT
Route::get($route.'/categoria/{SERV05ServicesCategory:slug}', [SERV05Controller::class, 'page'])->name($routeName.'.category.page');
