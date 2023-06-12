<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Units\UNIT03TopicController;
use App\Http\Controllers\Units\UNIT03BannerController;
use App\Http\Controllers\Units\UNIT03SocialController;
use App\Http\Controllers\Units\UNIT03CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Units';
$model = 'UNIT03';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', UNIT03CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'UNIT03UnitsCategory']);
    Route::post($route.'/categoria/delete', [UNIT03CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [UNIT03CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/topicos', UNIT03TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'UNIT03UnitsTopic']);
    Route::post($route.'/topico/delete', [UNIT03TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [UNIT03TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    Route::resource($route.'/sociais', UNIT03SocialController::class)->names('admin.'.$routeName.'.social')->parameters(['sociais' => 'UNIT03UnitsSocial']);
    Route::post($route.'/social/delete', [UNIT03SocialController::class, 'destroySelected'])->name('admin.'.$routeName.'.social.destroySelected');
    Route::post($route.'/social/sorting', [UNIT03SocialController::class, 'sorting'])->name('admin.'.$routeName.'.social.sorting');

    Route::resource($route.'/banner', UNIT03BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'UNIT03UnitsBanner']);
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
