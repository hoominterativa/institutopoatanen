<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Galleries\GALL03ImageController;
use App\Http\Controllers\Galleries\GALL03BannerController;
use App\Http\Controllers\Galleries\GALL03SectionController;
use App\Http\Controllers\Galleries\GALL03SectionGalleryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Galleries';
$model = 'GALL03';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){

    Route::resource($route.'/secaogaleria', GALL03SectionGalleryController::class)->names('admin.'.$routeName.'.sectionGallery')->parameters(['secaogaleria' => 'GALL03GalleriesSectionGallery']);
    Route::resource($route.'/secao', GALL03SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'GALL03GalleriesSection']);

    Route::resource($route.'/banner', GALL03BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'GALL03GalleriesBanner']);

    Route::resource($route.'/imagens', GALL03ImageController::class)->names('admin.'.$routeName.'.image')->parameters(['imagens' => 'GALL03GalleriesImage']);
    Route::post($route.'/imagem/delete', [GALL03ImageController::class, 'destroySelected'])->name('admin.'.$routeName.'.image.destroySelected');
    Route::post($route.'/imagem/sorting', [GALL03ImageController::class, 'sorting'])->name('admin.'.$routeName.'.image.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
