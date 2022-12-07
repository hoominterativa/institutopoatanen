<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT01GalleryController;
use App\Http\Controllers\Portfolios\PORT01SectionController;
use App\Http\Controllers\Portfolios\PORT01CategoryController;
use App\Http\Controllers\Portfolios\PORT01Controller;
use App\Http\Controllers\Portfolios\PORT01SubategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Portfolios';
$model = 'PORT01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    // CTAEGORIES
    Route::resource($route.'/categorias', PORT01CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT01PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [PORT01CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PORT01CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    // SUBCATEGORIES
    Route::resource($route.'/subcategorias', PORT01SubategoryController::class)->names('admin.'.$routeName.'.subcategory')->parameters(['subcategorias' => 'PORT01PortfoliosSubategory']);
    Route::post($route.'/subcategoria/delete', [PORT01SubategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.subcategory.destroySelected');
    Route::post($route.'/subcategoria/sorting', [PORT01SubategoryController::class, 'sorting'])->name('admin.'.$routeName.'.subcategory.sorting');

    // GALLERIES
    Route::resource($route.'/galeria', PORT01GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'PORT01PortfoliosGallery']);
    Route::post($route.'/galeria/delete', [PORT01GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [PORT01GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    // SECTION
    Route::resource($route.'/informacoes-secao', PORT01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['informacoes-secao' => 'PORT01PortfoliosSection']);
});

// CLIENT
Route::get($route.'/categoria/{PORT01PortfoliosCategory:slug}', [PORT01Controller::class, 'page'])->name($routeName.'.category.page');
Route::get($route.'/categoria/{PORT01PortfoliosCategory:slug}/subcategoria/{PORT01PortfoliosSubategory:slug}', [PORT01Controller::class, 'page'])->name($routeName.'.subcategory.page');
