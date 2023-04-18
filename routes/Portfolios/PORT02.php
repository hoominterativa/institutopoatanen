<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT02BannerController;
use App\Http\Controllers\Portfolios\PORT02GalleryController;
use App\Http\Controllers\Portfolios\PORT02SectionController;

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
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', PORT02SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'PORT02PortfoliosSection']);
    Route::post($route.'/secao/delete', [PORT02SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');

    Route::resource($route.'/banner', PORT02BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'PORT02PortfoliosBanner']);
    Route::post($route.'/banner/delete', [PORT02BannerController::class, 'destroySelected'])->name('admin.'.$routeName.'.banner.destroySelected');
    Route::post($route.'/banner/sorting', [PORT02BannerController::class, 'sorting'])->name('admin.'.$routeName.'.banner.sorting');

    Route::resource($route.'/galeria', PORT02GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'PORT02PortfoliosGallery']);
    Route::post($route.'/galeria/delete', [PORT02GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [PORT02GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
