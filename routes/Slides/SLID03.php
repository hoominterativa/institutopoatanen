<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Slides\SLID03Controller;
use App\Http\Controllers\Slides\SLID03FormController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Slides';
$model = 'SLID03';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// // ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/informacoes-formulario', SLID03FormController::class)->names('admin.'.$routeName.'.infoForm')->parameters(['informacoes-formulario' => 'SLID03SlidesForm']);

    Route::post($route.'/inputs', [SLID03FormController::class, 'inputStore'])->name('admin.'.$routeName.'.inputStore');
    Route::put($route.'/inputs/{SLID03SlidesForm}', [SLID03FormController::class, 'inputUpdate'])->name('admin.'.$routeName.'.inputUpdate');

    Route::post($route.'/additionals', [SLID03FormController::class, 'additionalStore'])->name('admin.'.$routeName.'.additionalStore');
    Route::put($route.'/additionals/{SLID03SlidesForm}', [SLID03FormController::class, 'additionalUpdate'])->name('admin.'.$routeName.'.additionalUpdate');
});

// // CLIENT
Route::post($route.'/get/additionals', [SLID03Controller::class, 'additionals'])->name($routeName.'.additionals');
Route::post($route.'/leads', [SLID03Controller::class, 'leads'])->name($routeName.'.leads');
