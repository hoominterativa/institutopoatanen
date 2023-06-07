<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Abouts\ABOU04BannerController;
use App\Http\Controllers\Abouts\ABOU04GalleryController;
use App\Http\Controllers\Abouts\ABOU04SectionController;
use App\Http\Controllers\Abouts\ABOU04SectionGalleryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Abouts';
$model = 'ABOU04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){

    Route::resource($route.'/banner', ABOU04BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'ABOU04AboutsBanner']);

    Route::resource($route.'/secao', ABOU04SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'ABOU04AboutsSection']);

    Route::resource($route.'/secaogaleria', ABOU04SectionGalleryController::class)->names('admin.'.$routeName.'.sectionGallery')->parameters(['secaogaleria' => 'ABOU04AboutsSectionGallery']);

    Route::resource($route.'/galeria', ABOU04GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'ABOU04AboutsGallery']);
    Route::post($route.'/galeria/delete', [ABOU04GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [ABOU04GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
