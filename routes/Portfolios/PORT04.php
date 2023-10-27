<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT04Controller;
use App\Http\Controllers\Portfolios\PORT04TopicController;
use App\Http\Controllers\Portfolios\PORT04GalleryController;
use App\Http\Controllers\Portfolios\PORT04SectionController;
use App\Http\Controllers\Portfolios\PORT04CategoryController;
use App\Http\Controllers\Portfolios\PORT04AdditionalTopicController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Portfolios';
$model = 'PORT04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', PORT04SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'PORT04PortfoliosSection']);

    Route::resource($route.'/categorias', PORT04CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT04PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [PORT04CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PORT04CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/topicos-adicionais', PORT04AdditionalTopicController::class)->names('admin.'.$routeName.'.additional-topics')->parameters(['topicos-adicionais' => 'PORT04PortfoliosAdditionalTopic']);
    Route::post($route.'/topicos-adicionais/delete', [PORT04AdditionalTopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.additional-topics.destroySelected');
    Route::post($route.'/topicos-adicionais/sorting', [PORT04AdditionalTopicController::class, 'sorting'])->name('admin.'.$routeName.'.additional-topics.sorting');

    Route::resource($route.'/topicos', PORT04TopicController::class)->names('admin.'.$routeName.'.topics')->parameters(['topicos' => 'PORT04PortfoliosTopic']);
    Route::post($route.'/topicos/delete', [PORT04TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topics.destroySelected');
    Route::post($route.'/topicos/sorting', [PORT04TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topics.sorting');

    Route::resource($route.'/galeria', PORT04GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'PORT04PortfoliosGallery']);
    Route::post($route.'/galeria/delete', [PORT04GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [PORT04GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');
});

// CLIENT
Route::get($route.'/categoria/{PORT04PortfoliosCategory:slug}', [PORT04Controller::class, 'page'])->name($routeName.'.category.page');
Route::get('categoria/{PORT04PortfoliosCategory:slug}/'.$route.'/{PORT04Portfolios:slug}', [PORT04Controller::class, 'show'])->name($routeName.'.page.content');
