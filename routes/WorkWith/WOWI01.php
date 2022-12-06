<?php

use App\Http\Controllers\WorkWith\WOWI01SectionController;
use App\Http\Controllers\WorkWith\WOWI01TopicController;
use App\Http\Controllers\WorkWith\WOWI01TopicSectionController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'WorkWith';
$model = 'WOWI01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    // Section
    Route::resource($route.'/section', WOWI01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['section' => 'WOWI01WorkWithSection']);
    Route::post($route.'/section/delete', [WOWI01SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');
    Route::post($route.'/section/sorting', [WOWI01SectionController::class, 'sorting'])->name('admin.'.$routeName.'.section.sorting');

    // SECTION TOPICS
    Route::resource($route.'/section-topic', WOWI01TopicSectionController::class)->names('admin.'.$routeName.'.sectionTopic')->parameters(['section-topic' => 'WOWI01WorkWithTopic']);
    Route::post($route.'/section-topic/delete', [WOWI01TopicSectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.sectionTopic.destroySelected');
    Route::post($route.'/section-topic/sorting', [WOWI01TopicSectionController::class, 'sorting'])->name('admin.'.$routeName.'.sectionTopic.sorting');

    // TOPICS
    Route::resource($route.'/topic', WOWI01TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topic' => 'WOWI01WorkWithTopic']);
    Route::post($route.'/topic/delete', [WOWI01TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topic/sorting', [WOWI01TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
});
// CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
