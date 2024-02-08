<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Topics\TOPI04GalleryController;
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
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/topicos', TOPI04TopicSectionController::class)->names('admin.'.$routeName.'.topic.section')->parameters(['topicos' => 'TOPI04TopicsTopicSection']);
    Route::post($route.'/topico/delete', [TOPI04TopicSectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.section.destroySelected');
    Route::post($route.'/topico/sorting', [TOPI04TopicSectionController::class, 'sorting'])->name('admin.'.$routeName.'.topic.section.sorting');

    Route::resource($route.'/galeria', TOPI04GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'TOPI04TopicsGallery']);
    Route::post($route.'/imagem/delete', [TOPI04GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/imagem/sorting', [TOPI04GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

});
