<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT02Controller;
use App\Http\Controllers\Portfolios\PORT02BannerController;
use App\Http\Controllers\Portfolios\PORT02GalleryController;
use App\Http\Controllers\Portfolios\PORT02SectionController;
use App\Http\Controllers\Portfolios\PORT02CategoryController;
use App\Http\Controllers\Portfolios\PORT02BannerHomeController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Portfolios';
$model = 'PORT02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', PORT02SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'PORT02PortfoliosSection']);

    Route::resource($route.'/banner', PORT02BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'PORT02PortfoliosBanner']);
    Route::post($route.'/banner/delete', [PORT02BannerController::class, 'destroySelected'])->name('admin.'.$routeName.'.banner.destroySelected');

    Route::resource($route.'/bannerHome', PORT02BannerHomeController::class)->names('admin.'.$routeName.'.banner.home')->parameters(['bannerHome' => 'PORT02PortfoliosBannerHome']);
    Route::post($route.'/bannerHome/delete', [PORT02BannerHomeController::class, 'destroySelected'])->name('admin.'.$routeName.'.banner.home.destroySelected');

    Route::resource($route.'/galeria', PORT02GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'PORT02PortfoliosGallery']);
    Route::post($route.'/galeria/delete', [PORT02GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [PORT02GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    Route::resource($route.'/categorias', PORT02CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT02PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [PORT02CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PORT02CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
});

// CLIENT
Route::get($route.'/categoria/{PORT02PortfoliosCategory:slug}', [PORT02Controller::class, 'page'])->name($routeName.'.category.page');
