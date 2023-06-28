<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV06Controller;
use App\Http\Controllers\Services\SERV06BannerController;
use App\Http\Controllers\Services\SERV06SectionController;
use App\Http\Controllers\Services\SERV06CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV06';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', SERV06CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV06ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV06CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV06CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/secao', SERV06SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV06ServicesSection']);
    Route::resource($route.'/banner', SERV06BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'SERV06ServicesBanner']);
});
// // CLIENT
Route::get($route.'/categoria/{SERV06ServicesCategory:slug}', [SERV06Controller::class, 'page'])->name($routeName.'.category.page');
