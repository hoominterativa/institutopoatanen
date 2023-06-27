<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Feedbacks\FEED06SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Feedbacks';
$model = 'FEED06';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', FEED06SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'FEED06FeedbacksSection']);});

