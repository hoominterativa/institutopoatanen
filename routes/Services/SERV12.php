<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV12TopicController;
use App\Http\Controllers\Services\SERV12CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV12';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Categories
    Route::resource($route.'/categorias', SERV12CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV12ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV12CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV12CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
    //Topics
    Route::resource($route.'/topicos', SERV12TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'SERV12ServicesTopic']);
    Route::post($route.'/topico/delete', [SERV12TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [SERV12TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
