<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Brands\BRAN01SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Brands';
$model = 'BRAN01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', BRAN01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'BRAN01BrandsSection']);
    Route::post($route.'/secao/delete', [BRAN01SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');

    // Route::post($route.'/categoria/sorting', [TEST01Controller::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
