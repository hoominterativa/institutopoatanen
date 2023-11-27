<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentPages\COPA01TopicController;
use App\Http\Controllers\ContentPages\COPA01SectionController;
use App\Http\Controllers\ContentPages\COPA01SectionArchiveController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'ContentPages';
$model = 'COPA01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    // SECTIONS
    Route::resource($route.'/sections', COPA01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['sections' => 'COPA01ContentPagesSection']);
    Route::post($route.'/sections/delete', [COPA01SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');
    Route::post($route.'/sections/sorting', [COPA01SectionController::class, 'sorting'])->name('admin.'.$routeName.'.section.sorting');
    // ARCHIVES
    Route::resource($route.'/archives', COPA01SectionArchiveController::class)->names('admin.'.$routeName.'.archive')->parameters(['archives' => 'COPA01ContentPagesSectionArchive']);
    Route::post($route.'/archives/delete', [COPA01SectionArchiveController::class, 'destroySelected'])->name('admin.'.$routeName.'.archive.destroySelected');
    Route::post($route.'/archives/sorting', [COPA01SectionArchiveController::class, 'sorting'])->name('admin.'.$routeName.'.archive.sorting');
    // TOPICS
    Route::resource($route.'/topicos', COPA01TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'COPA01ContentPagesTopic']);
    Route::post($route.'/topicos/delete', [COPA01TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topicos/sorting', [COPA01TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
});
