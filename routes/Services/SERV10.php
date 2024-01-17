<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV10Controller;
use App\Http\Controllers\Services\SERV10TopicController;
use App\Http\Controllers\Services\SERV10ContentController;
use App\Http\Controllers\Services\SERV10GalleryController;
use App\Http\Controllers\Services\SERV10SectionController;
use App\Http\Controllers\Services\SERV10CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV10';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Categories
    Route::resource($route.'/categorias', SERV10CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV10ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV10CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV10CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    //Content
    Route::resource($route.'/conteudos', SERV10ContentController::class)->names('admin.'.$routeName.'.content')->parameters(['conteudos' => 'SERV10ServicesContent']);
    Route::post($route.'/conteudo/delete', [SERV10ContentController::class, 'destroySelected'])->name('admin.'.$routeName.'.content.destroySelected');
    Route::post($route.'/conteudo/sorting', [SERV10ContentController::class, 'sorting'])->name('admin.'.$routeName.'.content.sorting');

    //Topics
    Route::resource($route.'/topicos', SERV10TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'SERV10ServicesTopic']);
    Route::post($route.'/topico/delete', [SERV10TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [SERV10TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    //Galleries
    Route::resource($route.'/galeria', SERV10GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'SERV10ServicesGallery']);
    Route::post($route.'/imagem/delete', [SERV10GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/imagem/sorting', [SERV10GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    //Sections
    Route::resource($route.'/secao', SERV10SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV10ServicesSection']);
});
Route::get($route.'/categoria/{SERV10ServicesCategory:slug}', [SERV10Controller::class, 'page'])->name($routeName.'.category.page');
Route::get('categoria/{SERV10ServicesCategory:slug}/'.$route.'/{SERV10Services:slug}', [SERV10Controller::class, 'show'])->name($routeName.'.page.content');
