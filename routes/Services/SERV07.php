<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV07Controller;
use App\Http\Controllers\Services\SERV07VideoController;
use App\Http\Controllers\Services\SERV07SectionController;
use App\Http\Controllers\Services\SERV07CategoryController;
use App\Http\Controllers\Services\SERV07TopicCategoryController;
use App\Http\Controllers\Services\SERV07GalleryServiceController;
use App\Http\Controllers\Services\SERV07GalleryCategoryController;
use App\Http\Controllers\Services\SERV07SectionCategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV07';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Category
    Route::resource($route.'/categorias', SERV07CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV07ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV07CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV07CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    //Additional Category Information
    Route::resource($route.'/info-categoria', SERV07CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['info-categoria' => 'SERV07ServicesCategory']);

    //Section Category
    Route::resource($route.'/secao-categorias', SERV07SectionCategoryController::class)->names('admin.'.$routeName.'.section-category')->parameters(['secao-categorias' => 'SERV07ServicesSectionCategory']);
    Route::post($route.'/secao-categoria/delete', [SERV07SectionCategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.section-category.destroySelected');
    Route::post($route.'/secao-categoria/sorting', [SERV07SectionCategoryController::class, 'sorting'])->name('admin.'.$routeName.'.section-category.sorting');

    //Video Category
    Route::resource($route.'/videos', SERV07VideoController::class)->names('admin.'.$routeName.'.video')->parameters(['videos' => 'SERV07ServicesVideo']);
    Route::post($route.'/video/delete', [SERV07VideoController::class, 'destroySelected'])->name('admin.'.$routeName.'.video.destroySelected');
    Route::post($route.'/video/sorting', [SERV07VideoController::class, 'sorting'])->name('admin.'.$routeName.'.video.sorting');

    //Gallery Category
    Route::resource($route.'/galeria-categorias', SERV07GalleryCategoryController::class)->names('admin.'.$routeName.'.gallery-category')->parameters(['galeria-categorias' => 'SERV07ServicesGalleryCategory']);
    Route::post($route.'/galeria-categoria/delete', [SERV07GalleryCategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery-category.destroySelected');
    Route::post($route.'/galeria-categoria/sorting', [SERV07GalleryCategoryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery-category.sorting');

    //Gallery Service
    Route::resource($route.'/galeria-servicos', SERV07GalleryServiceController::class)->names('admin.'.$routeName.'.gallery-service')->parameters(['galeria-servicos' => 'SERV07ServicesGalleryService']);
    Route::post($route.'/galeria-servico/delete', [SERV07GalleryServiceController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery-service.destroySelected');
    Route::post($route.'/galeria-servico/sorting', [SERV07GalleryServiceController::class, 'sorting'])->name('admin.'.$routeName.'.gallery-service.sorting');

    //Topic Category
    Route::resource($route.'/topicos-categorias', SERV07TopicCategoryController::class)->names('admin.'.$routeName.'.topic-category')->parameters(['topicos-categorias' => 'SERV07ServicesTopicCategory']);
    Route::post($route.'/topico-categoria/delete', [SERV07TopicCategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic-category.destroySelected');
    Route::post($route.'/topico-categoria/sorting', [SERV07TopicCategoryController::class, 'sorting'])->name('admin.'.$routeName.'.topic-category.sorting');

    //Section
    Route::resource($route.'/secao', SERV07SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV07ServicesSection']);

    //Banner
    Route::resource($route.'/banner', SERV07SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['banner' => 'SERV07ServicesSection']);
});
// CLIENT

Route::get($route.'/categoria/{SERV07ServicesCategory:slug}', [SERV07Controller::class, 'page'])->name($routeName.'.category.page');
Route::get($route. '/{SERV07Services:slug}', [SERV07Controller::class, 'show'])->name($routeName.'.page.content');

