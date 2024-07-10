<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\Portfolios\PORT05Portfolios;
use App\Http\Controllers\Portfolios\PORT05GalleryController;
use App\Http\Controllers\Portfolios\PORT05SectionController;
use App\Http\Controllers\Portfolios\PORT05CategoryController;
use App\Http\Controllers\Portfolios\PORT05Controller;
use App\Http\Controllers\Portfolios\PORT05TestimonialController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Portfolios';
$model = 'PORT05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', PORT05CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT05PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [PORT05CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PORT05CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/secao', PORT05SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'PORT05PortfoliosSection']);

    Route::resource($route.'/galeria', PORT05GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'PORT05PortfoliosGallery']);
    Route::post($route.'/galeria/delete', [PORT05GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [PORT05GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    Route::resource($route.'/depoimentos', PORT05TestimonialController::class)->names('admin.'.$routeName.'.testimonial')->parameters(['depoimentos' => 'PORT05PortfoliosTestimonial']);
    Route::post($route.'/depoimento/delete', [PORT05TestimonialController::class, 'destroySelected'])->name('admin.'.$routeName.'.testimonial.destroySelected');
    Route::post($route.'/depoimento/sorting', [PORT05TestimonialController::class, 'sorting'])->name('admin.'.$routeName.'.testimonial.sorting');

    Route::get('/teste', function() {
        $portfolio = PORT05Portfolios::find(1);
        // $portfolio->categories->get();
        dd($portfolio->categories->get());
    });
});
// CLIENT
Route::get($route.'/categoria/{PORT05PortfoliosCategory:slug}', [PORT05Controller::class, 'page'])->name($routeName.'.category.page');
Route::get($route.'/{PORT05Portfolios:slug}', [PORT05Controller::class, 'show'])->name($routeName.'.show');
