<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV04TopicController;
use App\Http\Controllers\Services\SERV04SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', SERV04SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV04ServicesSection']);
    Route::post($route.'/secao/delete', [SERV04SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');

    Route::resource($route.'/topicos', SERV04TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'SERV04ServicesTopic']);
    Route::post($route.'/topicos/delete', [SERV04TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topicos/sorting', [SERV04TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
