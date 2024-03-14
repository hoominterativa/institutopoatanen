<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contacts\COTA05Controller;
use App\Http\Controllers\Contacts\COTA05AssessmentController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contacts';
$model = 'COTA05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/avaliacoes', COTA05AssessmentController::class)->names('admin.'.$routeName.'.assessment')->parameters(['avaliacoes' => 'COTA05Contacts']);
});
// CLIENT
Route::post($route.'/inputs/website', [COTA05Controller::class ,'storeInputs'])->name($routeName.'.lead.store');
