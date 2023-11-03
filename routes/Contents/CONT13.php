<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contents\CONT13TopicController;
use App\Http\Controllers\Contents\CONT13GalleryController;
use App\Http\Controllers\Contents\CONT13SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contents';
$model = 'CONT13';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/topicos', CONT13TopicController::class)->names('admin.'.$routeName.'.topics')->parameters(['topicos' => 'CONT13ContentsTopic']);
    Route::post($route.'/topicos/delete', [CONT13TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topics.destroySelected');
    Route::post($route.'/topicos/sorting', [CONT13TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topics.sorting');

    Route::resource($route.'/galerias', CONT13GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galerias' => 'CONT13ContentsGallery']);
    Route::post($route.'/galeria/delete', [CONT13GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [CONT13GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    Route::resource($route.'/secao', CONT13SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'CONT13ContentsSection']);
});
