<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV12Controller;
use App\Http\Controllers\Services\SERV12TopicController;
use App\Http\Controllers\Services\SERV12VideoController;
use App\Http\Controllers\Services\SERV12GalleryController;
use App\Http\Controllers\Services\SERV12SectionController;
use App\Http\Controllers\Services\SERV12CategoryController;
use App\Http\Controllers\Services\SERV12TopicGalleryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV12';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Categories
    Route::resource($route.'/categorias', SERV12CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV12ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV12CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV12CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
    //Topics
    Route::resource($route.'/topicos', SERV12TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'SERV12ServicesTopic']);
    Route::post($route.'/topico/delete', [SERV12TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [SERV12TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
    //Galleries
    Route::resource($route.'/galerias', SERV12GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galerias' => 'SERV12ServicesGallery']);
    Route::post($route.'/galeria/delete', [SERV12GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [SERV12GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');
    //Video
    Route::resource($route.'/video', SERV12VideoController::class)->names('admin.'.$routeName.'.video')->parameters(['video' => 'SERV12ServicesVideo']);
    //Section
    Route::resource($route.'/section', SERV12SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['section' => 'SERV12ServicesSection']);
    //TopicGalleries
    Route::resource($route.'/galeriastopicos', SERV12TopicGalleryController::class)->names('admin.'.$routeName.'.gallery-topic')->parameters(['galeriastopicos' => 'SERV12ServicesTopicGallery']);
    Route::post($route.'/galeriatopico/delete', [SERV12TopicGalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery-topic.destroySelected');
    Route::post($route.'/galeriatopic/sorting', [SERV12TopicGalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery-topic.sorting');
});
// CLIENT
Route::get($route.'/categoria/{SERV12ServicesCategory:slug}/{SERV12Services:slug?}', [SERV12Controller::class, 'page'])->name($routeName.'.category.page');

