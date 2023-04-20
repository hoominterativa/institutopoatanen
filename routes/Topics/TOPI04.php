<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Topics\TOPI04TopicSectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Topics';
$model = 'TOPI04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/topicos', TOPI04TopicSectionController::class)->names('admin.'.$routeName.'.topic.section')->parameters(['topicos' => 'TOPI04TopicTopicSection']);
    Route::post($route.'/topico/delete', [TOPI04TopicSectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.section.destroySelected');
    Route::post($route.'/topico/sorting', [TOPI04TopicSectionController::class, 'sorting'])->name('admin.'.$routeName.'.topic.section.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
