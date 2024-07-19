<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentPages\COPA04Controller;
use App\Models\ContentPages\COPA04ContentPagesSectionHero;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'ContentPages';
$model = 'COPA04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/copa04', COPA04Controller::class)->names('admin.'.$routeName.'.index')->parameters(['copa04' => 'COPA04ContentPages']);
    Route::post($route.'/categoria/delete', [COPA04Controller::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [COPA04Controller::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
    
    Route::resource($route.'/copa04', COPA04ContentPagesSectionHero::class)->names('admin.'.$routeName.'.index')->parameters(['copa04' => 'COPA04ContentPages']);
    Route::post($route.'/categoria/delete', [COPA04ContentPagesSectionHero::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [COPA04ContentPagesSectionHero::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [COPA04Controller::class, 'page'])->name($routeName.'.page');
