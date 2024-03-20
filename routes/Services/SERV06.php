<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV06Controller;
use App\Http\Controllers\Services\SERV06BannerController;
use App\Http\Controllers\Services\SERV06SectionController;
use App\Http\Controllers\Services\SERV06CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV06';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', SERV06SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV06ServicesSection']);
});

