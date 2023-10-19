<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Abouts\ABOU02TopicController;
use App\Http\Controllers\Abouts\ABOU02SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Abouts';
$model = 'ABOU02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){

    Route::resource($route.'/topicos', ABOU02TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'ABOU02AboutsTopic']);
    Route::post($route.'/topico/delete', [ABOU02TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [ABOU02TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    Route::resource($route.'/secao-topicos', ABOU02SectionController::class)->names('admin.'.$routeName.'.section-topics')->parameters(['secao-topicos' => 'ABOU02AboutsSection']);
    Route::resource($route.'/banner', ABOU02SectionController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'ABOU02AboutsSection']);
    Route::resource($route.'/conteudo', ABOU02SectionController::class)->names('admin.'.$routeName.'.content')->parameters(['conteudo' => 'ABOU02AboutsSection']);
    Route::resource($route.'/secao', ABOU02SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'ABOU02AboutsSection']);

});
