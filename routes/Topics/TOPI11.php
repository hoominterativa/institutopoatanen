<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Topics\TOPI11ImageController;
use App\Http\Controllers\Topics\TOPI11SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Topics';
$model = 'TOPI11';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', TOPI11SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'TOPI11TopicsSection']);

    Route::resource($route.'/Imagem', TOPI11ImageController::class)->names('admin.'.$routeName.'.image')->parameters(['Imagem' => 'TOPI11TopicsImagem']);
});
