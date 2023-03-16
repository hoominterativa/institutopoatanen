<?php

use App\Http\Controllers\Topics\TOPI101SectionController;
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
$model = 'TOPI101';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', TOPI101SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'TOPI101TopicsSection']);
    Route::post($route.'/secao/delete', [TOPI101SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');

    // Route::post($route.'/categoria/sorting', [TEST01Controller::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
});
// CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
