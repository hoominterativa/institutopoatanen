<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Units\UNIT01Controller;
use App\Http\Controllers\Units\UNIT01TopicController;
use App\Http\Controllers\Units\UNIT01BannerController;
use App\Http\Controllers\Units\UNIT01GalleryController;
use App\Http\Controllers\Units\UNIT01SectionController;
use App\Http\Controllers\Units\UNIT01CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Units';
$model = 'UNIT01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', UNIT01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'UNIT01UnitsSection']);

    Route::resource($route.'/topicos', UNIT01TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'UNIT01UnitsTopic']);
    Route::post($route.'/topico/delete', [UNIT01TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [UNIT01TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    Route::resource($route.'/galerias', UNIT01GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galerias' => 'UNIT01UnitsGallery']);
    Route::post($route.'/galeria/delete', [UNIT01GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [UNIT01GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    Route::resource($route.'/categorias', UNIT01CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'UNIT01UnitsCategory']);
    Route::post($route.'/categoria/delete', [UNIT01CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [UNIT01CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
});
// CLIENT
Route::get($route.'/categoria/{UNIT01UnitsCategory:slug}', [UNIT01Controller::class, 'page'])->name($routeName.'.category.page');
Route::get('categoria/{UNIT01UnitsCategory:slug}/'.$route.'/{UNIT01Units:slug}', [UNIT01Controller::class, 'show'])->name($routeName.'.show');
