<?php

use App\Http\Controllers\Topics\TOPI102FeaturedTopicsController;
use App\Http\Controllers\Topics\TOPI102SectionController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Topics';
$model = 'TOPI102';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName) {
    Route::resource($route . '/secao', TOPI102SectionController::class)->names('admin.' . $routeName . '.section')->parameters(['secao' => 'TOPI102TopicsSection']);

    Route::resource($route . '/topicodestaque', TOPI102FeaturedTopicsController::class)->names('admin.' . $routeName . '.featured.topic')->parameters(['topicodestaque' => 'TOPI102TopicsFeaturedTopics']);
    Route::post($route . '/topicodestaque/delete', [TOPI102FeaturedTopicsController::class, 'destroySelected'])->name('admin.' . $routeName . '.featured.topic.destroySelected');
    Route::post($route . '/topicodestaque/sorting', [TOPI102FeaturedTopicsController::class, 'sorting'])->name('admin.' . $routeName . '.featured.topic.sorting');
});
