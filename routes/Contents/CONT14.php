<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contents\CONT14Controller;
use App\Http\Controllers\Contents\CONT14SectionController;
use App\Http\Controllers\Contents\CONT14CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contents';
$model = 'CONT14';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', CONT14CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'CONT14ContentsCategory']);
    Route::post($route.'/categoria/delete', [CONT14CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [CONT14CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    //Section
    Route::resource($route.'/secao', CONT14SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'CONT14ContentsSection']);

});

// CLIENT
Route::post($route.'/{CONT14ContentsCategory}', [CONT14Controller::class, 'show'])->name($routeName.'.show');
