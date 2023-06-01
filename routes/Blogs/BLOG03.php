<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blogs\BLOG03Controller;
use App\Http\Controllers\Blogs\BLOG03BannerController;
use App\Http\Controllers\Blogs\BLOG03SectionController;
use App\Http\Controllers\Blogs\BLOG03CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Blogs';
$model = 'BLOG03';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', BLOG03CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'BLOG03BlogsCategory']);
    Route::post($route.'/categoria/delete', [BLOG03CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [BLOG03CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::post('busca/'.$route, [BLOG03Controller::class, 'filter'])->name('admin.'.$routeName.'.index.filter');
    Route::get('clearFilter/'.$route, [BLOG03Controller::class, 'clearFilter'])->name('admin.'.$routeName.'.clearFilter');

    Route::resource($route.'/secao', BLOG03SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'BLOG03BlogsSection']);

    Route::resource($route.'/banner', BLOG03BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'BLOG03BlogsBanner']);
});
// // CLIENT
Route::get($route.'/categoria/{BLOG03BlogsCategory:slug}', [BLOG03Controller::class, 'page'])->name($routeName.'.category.page');
Route::get('categoria/{BLOG03BlogsCategory:slug}/'.$route.'/{BLOG03Blogs:slug}', [BLOG03Controller::class, 'show'])->name($routeName.'.show.content');
Route::get('buscar/'.$route, [BLOG03Controller::class, 'page'])->name($routeName.'.search');

