<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Abouts\ABOU01TopicsController;
use App\Http\Controllers\Abouts\ABOU01SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Abouts';
$model = 'ABOU01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/topicos', ABOU01TopicsController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'ABOU01AboutsTopics']);
    Route::post($route.'/topicos/delete', [ABOU01TopicsController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topicos/sorting', [ABOU01TopicsController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    Route::resource($route.'/secao', ABOU01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'ABOU01AboutsSection']);
    Route::resource($route.'/banner', ABOU01SectionController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'ABOU01AboutsSection']);
    Route::resource($route.'/section-topics', ABOU01SectionController::class)->names('admin.'.$routeName.'.section-topics')->parameters(['section-topics' => 'ABOU01AboutsSection']);
    Route::resource($route.'/conteudo', ABOU01SectionController::class)->names('admin.'.$routeName.'.content')->parameters(['conteudo' => 'ABOU01AboutsSection']);
});
