<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blogs\BLOG01Controller;
use App\Http\Controllers\Blogs\BLOG01SectionController;
use App\Http\Controllers\Blogs\BLOG01CategoryController;

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
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel/')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', BLOG01CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'BLOG01BlogsCategory']);
    Route::post($route.'/categoria/delete', [BLOG01CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [BLOG01CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::post('busca/'.$route, [BLOG01Controller::class, 'filter'])->name('admin.'.$routeName.'.index.filter');
    Route::get('clearFilter/'.$route, [BLOG01Controller::class, 'clearFilter'])->name('admin.'.$routeName.'.clearFilter');

    Route::resource($route.'/secao', BLOG01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'BLOG01BlogsSection']);
    Route::resource($route.'/banner', BLOG01SectionController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'BLOG01BlogsSection']);
});

//CLIENT
Route::get($route.'/categoria/{BLOG01BlogsCategory:slug}', [BLOG01Controller::class, 'page'])->name($routeName.'.category.page');
Route::get('categoria/{BLOG01BlogsCategory:slug}/'.$route.'/{BLOG01Blogs:slug}', [BLOG01Controller::class, 'show'])->name($routeName.'.show.content');
