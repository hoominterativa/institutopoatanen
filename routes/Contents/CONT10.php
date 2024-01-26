<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\Contents\CONT10ContentsSection;
use App\Http\Controllers\Contents\CONT10TopicController;
use App\Http\Controllers\Contents\CONT10SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contents';
$model = 'CONT10';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/topicos', CONT10TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'CONT10ContentsTopic']);
    Route::post($route.'/topico/delete', [CONT10TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [CONT10TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
});
