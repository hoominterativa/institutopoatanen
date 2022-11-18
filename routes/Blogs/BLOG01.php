<?php

use App\Http\Controllers\Blogs\BLOG01CategoryController;
use App\Http\Controllers\Blogs\BLOG01Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Blogs';
$model = 'BLOG01';
$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', BLOG01CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'BLOG01BlogsCategory']);
    Route::post($route.'/categoria/delete', [BLOG01CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [BLOG01CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::post($route.'/busca', [BLOG01Controller::class, 'index'])->name('admin.'.$routeName.'.index.filter');
});
// CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
