<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV09Controller;
use App\Http\Controllers\Services\SERV09SectionController;
use App\Http\Controllers\Services\SERV09CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV09';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Categories
    Route::resource($route.'/categorias', SERV09CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV09ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV09CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV09CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    //Section Home
    Route::resource($route.'/secao', SERV09SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV09ServicesSection']);
});
// CLIENT
Route::get($route.'/categoria/{SERV09ServicesCategory:slug}', [SERV09Controller::class, 'page'])->name($routeName.'.category.page');
