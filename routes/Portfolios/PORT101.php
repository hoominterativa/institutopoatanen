<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT101GalleryController;
use App\Http\Controllers\Portfolios\PORT101SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Portfolios';
$model = 'PORT101';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', PORT101SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'PORT101PortfoliosSection']);

    Route::resource($route.'/galeria', PORT101GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'PORT101PortfoliosGallery']);
    Route::post($route.'/galeria/delete', [PORT101GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [PORT101GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
