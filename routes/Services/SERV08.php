<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV08Controller;
use App\Http\Controllers\Services\SERV08ContactController;
use App\Http\Controllers\Services\SERV08SectionController;
use App\Http\Controllers\Services\SERV08CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV08';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Categories
    Route::resource($route.'/categorias', SERV08CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV08ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV08CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV08CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    //Section Home
    Route::resource($route.'/secao', SERV08SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV08ServicesSection']);
    //Section Banner
    Route::resource($route.'/banner', SERV08SectionController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'SERV08ServicesSection']);
    // Section Content
    Route::resource($route.'/conteudo', SERV08SectionController::class)->names('admin.'.$routeName.'.content')->parameters(['conteudo' => 'SERV08ServicesSection']);

    //Contact
    Route::resource($route.'/contato', SERV08ContactController::class)->names('admin.'.$routeName.'.contact')->parameters(['contato' => 'SERV08ServicesContact']);
});
// CLIENT
Route::get($route.'/categoria/{SERV08ServicesCategory:slug}', [SERV08Controller::class, 'page'])->name($routeName.'.category.page');
