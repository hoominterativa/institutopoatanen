<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV05Controller;
use App\Http\Controllers\Services\SERV05TopicController;
use App\Http\Controllers\Services\SERV05ContentController;
use App\Http\Controllers\Services\SERV05GalleryController;
use App\Http\Controllers\Services\SERV05SectionController;
use App\Http\Controllers\Services\SERV05CategoryController;
use App\Http\Controllers\Services\SERV05GalleryServiceController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', SERV05CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'SERV05ServicesCategory']);
    Route::post($route.'/categoria/delete', [SERV05CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [SERV05CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/conteudos', SERV05ContentController::class)->names('admin.'.$routeName.'.content')->parameters(['conteudos' => 'SERV05ServicesContent']);
    Route::post($route.'/conteudo/delete', [SERV05ContentController::class, 'destroySelected'])->name('admin.'.$routeName.'.content.destroySelected');
    Route::post($route.'/conteudo/sorting', [SERV05ContentController::class, 'sorting'])->name('admin.'.$routeName.'.content.sorting');

    Route::resource($route.'/topicos', SERV05TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'SERV05ServicesTopic']);
    Route::post($route.'/topico/delete', [SERV05TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [SERV05TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    Route::resource($route.'/secao', SERV05SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV05ServicesSection']);
});
// CLIENT
Route::get($route.'/categoria/{SERV05ServicesCategory:slug}', [SERV05Controller::class, 'page'])->name($routeName.'.category.page');
Route::get('categoria/{SERV05ServicesCategory:slug}/'.$route.'/{SERV05Services:slug}', [SERV05Controller::class, 'show'])->name($routeName.'.show');
