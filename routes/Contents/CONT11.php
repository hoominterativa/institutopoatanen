<?php

use App\Http\Controllers\Contents\CONT11GalleryController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contents';
$model = 'CONT11';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/galerias', CONT11GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galerias' => 'CONT11ContentsGallery']);
    Route::post($route.'/galeria/delete', [CONT11GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [CONT11GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');
});
