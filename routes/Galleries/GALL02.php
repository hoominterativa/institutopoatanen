<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Galleries\GALL02ImageController;
use App\Http\Controllers\Galleries\GALL02SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Galleries';
$model = 'GALL02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', GALL02SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'GALL02GalleriesSection']);

    Route::resource($route.'/imagens', GALL02ImageController::class)->names('admin.'.$routeName.'.image')->parameters(['imagens' => 'GALL02GalleriesImage']);
    Route::post($route.'/imagem/delete', [GALL02ImageController::class, 'destroySelected'])->name('admin.'.$routeName.'.image.destroySelected');
    Route::post($route.'/imagem/sorting', [GALL02ImageController::class, 'sorting'])->name('admin.'.$routeName.'.image.sorting');

});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
