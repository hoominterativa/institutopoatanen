<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contents\CONT10V1TopicController;
use App\Http\Controllers\Contents\CONT10V1SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

 $module = 'Contents';
 $model = 'CONT10V1';

 $class = config('modelsConfig.Class');
 $modelConfig = config('modelsConfig.InsertModelsMain');
 $module = getNameModule($modelConfig, $module, $model);
 $modelConfig = $modelConfig->$module->$model->config;

 $route = Str::slug($modelConfig->titlePanel);
 $routeName = Str::lower($model);

 // ADMIN
 Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/topicos', CONT10V1TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'CONT10V1ContentsTopic']);
    Route::post($route.'/topico/delete', [CONT10V1TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [CONT10V1TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
 });
