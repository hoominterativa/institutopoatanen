<?php

use Illuminate\Support\Str;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 * Don't create  resource route
 */

// $module = 'TEST';
// $model = 'TEST01';

// $class = config('modelsConfig.Class');
// $modelConfig = config('modelsConfig.InsertModelsMain');
// $modelConfig = $modelConfig->$module->$model->config;

// $route = Str::slug($modelConfig->titlePanel);
// $routeName = Str::lower($model);

// // ADMIN
// Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
//     Route::post($route.'/teste', [TEST01Controller::class, 'sorting'])->name('admin.'.$routeName.'.sorting');
// });
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
