<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Feedbacks\FEED01SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Feedbacks';
$model = 'FEED01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', FEED01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'FEED01FeedbacksSection']);
    Route::post($route.'/secao/delete', [FEED01SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');

    // Route::post($route.'/categoria/sorting', [TEST01Controller::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
