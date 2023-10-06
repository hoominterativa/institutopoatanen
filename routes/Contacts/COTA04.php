<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contacts\COTA04CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contacts';
$model = 'COTA04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Categories
    Route::resource($route.'/categorias', COTA04CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'COTA04ContactsCategory']);
    Route::post($route.'/categoria/delete', [COTA04CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [COTA04CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
});
// CLIENT
Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
