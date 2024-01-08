<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentPages\COPA02TopicController;
use App\Http\Controllers\ContentPages\COPA02SectionController;
use App\Http\Controllers\ContentPages\COPA02LastSectionController;
use App\Http\Controllers\ContentPages\COPA02SectionTopicController;
use App\Http\Controllers\ContentPages\COPA02SectionContentController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'ContentPages';
$model = 'COPA02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', COPA02SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'COPA02ContentPagesSection']);

    Route::resource($route.'/topicos', COPA02TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'COPA02ContentPagesTopic']);
    Route::post($route.'/topico/delete', [COPA02TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [COPA02TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
});
