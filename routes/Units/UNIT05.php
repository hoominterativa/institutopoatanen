<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Units\UNIT05Controller;
use App\Http\Controllers\Units\UNIT05LinkController;
use App\Http\Controllers\Units\UNIT05ContentController;
use App\Http\Controllers\Units\UNIT05GalleryController;
use App\Http\Controllers\Units\UNIT05SectionController;
use App\Http\Controllers\Units\UNIT05CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Units';
$model = 'UNIT05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/conteudos', UNIT05ContentController::class)->names('admin.'.$routeName.'.content')->parameters(['conteudos' => 'UNIT05UnitsContent']);
    Route::post($route.'/conteudo/delete', [UNIT05ContentController::class, 'destroySelected'])->name('admin.'.$routeName.'.content.destroySelected');
    Route::post($route.'/conteudo/sorting', [UNIT05ContentController::class, 'sorting'])->name('admin.'.$routeName.'.content.sorting');

    Route::resource($route.'/links', UNIT05LinkController::class)->names('admin.'.$routeName.'.link')->parameters(['links' => 'UNIT05UnitsLink']);
    Route::post($route.'/link/delete', [UNIT05LinkController::class, 'destroySelected'])->name('admin.'.$routeName.'.link.destroySelected');
    Route::post($route.'/link/sorting', [UNIT05LinkController::class, 'sorting'])->name('admin.'.$routeName.'.link.sorting');

    Route::resource($route.'/galeria', UNIT05GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'UNIT05UnitsGallery']);
    Route::post($route.'/imagem/delete', [UNIT05GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/imagem/sorting', [UNIT05GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    Route::resource($route.'/categorias', UNIT05CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'UNIT05UnitsCategory']);
    Route::post($route.'/categoria/delete', [UNIT05CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [UNIT05CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/secao', UNIT05SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'UNIT05UnitsSection']);
});
// CLIENT
Route::get($route.'/categoria/{UNIT05UnitsCategory:slug}', [UNIT05Controller::class, 'page'])->name($routeName.'.category.page');
