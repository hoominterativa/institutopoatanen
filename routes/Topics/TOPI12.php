<?php

use App\Http\Controllers\Topics\TOPI12SectionController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Topics';
$model = 'TOPI12';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', TOPI12SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'TOPI12TopicsSection']);
});
