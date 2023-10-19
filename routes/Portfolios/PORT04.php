<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT04Controller;
use App\Http\Controllers\Portfolios\PORT04SectionController;
use App\Http\Controllers\Portfolios\PORT04CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Portfolios';
$model = 'PORT04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', PORT04SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'PORT02PortfoliosSection']);
    Route::resource($route.'/banner', PORT04SectionController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'PORT02PortfoliosSection']);
    Route::resource($route.'/conteudo', PORT04SectionController::class)->names('admin.'.$routeName.'.content')->parameters(['conteudo' => 'PORT02PortfoliosSection']);

    Route::resource($route.'/categorias', PORT04CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT04PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [PORT04CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PORT04CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
});

// CLIENT
Route::get($route.'/categoria/{PORT04PortfoliosCategory:slug}', [PORT04Controller::class, 'page'])->name($routeName.'.category.page');
