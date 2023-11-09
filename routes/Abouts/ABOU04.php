<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Abouts\ABOU04TopicController;
use App\Http\Controllers\Abouts\ABOU04GalleryController;
use App\Http\Controllers\Abouts\ABOU04SectionController;
use App\Http\Controllers\Abouts\ABOU04CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Abouts';
$model = 'ABOU04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){

    Route::resource($route.'/galeria', ABOU04GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'ABOU04AboutsGallery']);
    Route::post($route.'/galeria/delete', [ABOU04GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [ABOU04GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    Route::resource($route.'/topicos', ABOU04TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'ABOU04AboutsTopic']);
    Route::post($route.'/topico/delete', [ABOU04TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [ABOU04TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    Route::resource($route.'/categorias', ABOU04CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'ABOU04AboutsCategory']);
    Route::post($route.'/categoria/delete', [ABOU04CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [ABOU04CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');


});
