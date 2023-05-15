<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portals\POTA01Controller;
use App\Http\Controllers\Portals\POTA01CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Portals';
$model = 'POTA01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', POTA01CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'POTA01PortalsCategory']);
    Route::post($route.'/categoria/delete', [POTA01CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [POTA01CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::post('busca/'.$route, [POTA01Controller::class, 'filter'])->name('admin.'.$routeName.'.index.filter');
    Route::get('clearFilter/'.$route, [POTA01Controller::class, 'clearFilter'])->name('admin.'.$routeName.'.clearFilter');

    Route::resource($route.'/secao', POTA01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'BLOG01BlogsSection']);
});

//CLIENT
Route::get($route.'/categoria/{POTA01PortalsCategory:slug}', [POTA01Controller::class, 'page'])->name($routeName.'.category.page');
Route::get('categoria/{POTA01PortalsCategory:slug}/'.$route.'/{POTA01Portals:slug}', [POTA01Controller::class, 'show'])->name($routeName.'.show.content');
