<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\Abouts\ABOU05AboutsSection;
use App\Http\Controllers\Abouts\ABOU05SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Abouts';
$model = 'ABOU05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', TEST01Controller::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT01PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [TEST01Controller::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [TEST01Controller::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');
    //Section
    Route::resource($route.'/secao', ABOU05SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'ABOU05AboutsSection']);
    //Banner
    Route::resource($route.'/banner', ABOU05SectionController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'ABOU05AboutsSection']);
    //Section Content
    Route::resource($route.'/secao-conteudo', ABOU05SectionController::class)->names('admin.'.$routeName.'.section_content')->parameters(['secao-conteudo' => 'ABOU05AboutsSection']);
});
