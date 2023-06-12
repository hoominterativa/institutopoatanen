<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

// $module = 'TEST';
// $model = 'TEST01';

// $class = config('modelsConfig.Class');
// $modelConfig = config('modelsConfig.InsertModelsMain');
// $module = getNameModule($modelConfig, $module, $model);
// $modelConfig = $modelConfig->$module->$model->config;

// $route = Str::slug($modelConfig->titlePanel);
// $routeName = Str::lower($model);

// // ADMIN
// Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
//     Route::resource($route.'/categorias', TEST01Controller::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT01PortfoliosCategory']);
//     Route::post($route.'/categoria/delete', [TEST01Controller::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
//     Route::post($route.'/categoria/sorting', [TEST01Controller::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
// });
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
