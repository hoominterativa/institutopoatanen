<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV04Controller;
use App\Http\Controllers\Services\SERV04TopicController;
use App\Http\Controllers\Services\SERV04SectionController;
use App\Http\Controllers\Services\SERV04CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', SERV04SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV04ServicesSection']);
    Route::post($route.'/secao/delete', [SERV04SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');

    Route::resource($route.'/topicos', SERV04TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'SERV04ServicesTopic']);
    Route::post($route.'/topico/delete', [SERV04TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [SERV04TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    Route::resource($route.'/categorias', SERV04CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV04ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV04CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV04CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
});
// // CLIENT
Route::get($route.'/categoria/{SERV04ServicesCategory:slug}', [SERV04Controller::class, 'page'])->name($routeName.'.category.page');
Route::get('categoria/{SERV04ServicesCategory:slug}/'.$route.'/{SERV04Services:slug}', [SERV04Controller::class, 'show'])->name($routeName.'.show');
