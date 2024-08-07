<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Brands\BRAN02Controller;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

 $module = 'Brands';
 $model = 'BRAN02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);


Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
 Route::resource($route.'/categorias', BRAN02Controller::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT01PortfoliosCategory']);
   Route::post($route.'/categoria/delete', [BRAN02Controller::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [BRAN02Controller::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
 });
//  CLIENT
 Route::get($route.'/teste', [BRAN02Controller::class, 'page'])->name($routeName.'.page');
