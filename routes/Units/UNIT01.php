<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Units\UNIT01TopicController;
use App\Http\Controllers\Units\UNIT01BannerController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Units';
$model = 'UNIT01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/banner', UNIT01BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'UNIT01UnitsBanner']);

    Route::resource($route.'/topicos', UNIT01TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'UNIT01UnitsTopic']);
    Route::post($route.'/topico/delete', [UNIT01TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [UNIT01TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
