<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contents\CONT09TopicController;
use App\Http\Controllers\Contents\CONT09TopicSectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contents';
$model = 'CONT09';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/topicos', CONT09TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'CONT09ContentsTopic']);
    Route::post($route.'/topico/delete', [CONT09TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [CONT09TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');


    Route::resource($route . '/secao', CONT09TopicSectionController::class)->names('admin.' . $routeName . '.topicsection')->parameters(['secao' => 'CONT09ContentsTopicSection']);
    Route::post($route . '/secao/delete', [CONT09TopicSectionController::class, 'destroySelected'])->name('admin.' . $routeName . '.topicsection.destroySelected');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
