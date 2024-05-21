<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV11Controller;
use App\Http\Controllers\Services\SERV11SectionController;
use App\Http\Controllers\Services\SERV11SessionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV11';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/sessoes', SERV11SessionController::class)->names('admin.'.$routeName.'.session')->parameters(['sessoes' => 'SERV11ServicesSession']);
    Route::post($route.'/sessao/delete', [SERV11SessionController::class, 'destroySelected'])->name('admin.'.$routeName.'.session.destroySelected');
    Route::post($route.'/sessao/sorting', [SERV11SessionController::class, 'sorting'])->name('admin.'.$routeName.'.session.sorting');

    Route::resource($route.'/secao', SERV11SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV11ServicesSection']);
});
// CLIENT
Route::get($route . '/sessao/{SERV11ServicesSession:slug}', [SERV11Controller::class, 'page'])->name($routeName . '.session.page');
