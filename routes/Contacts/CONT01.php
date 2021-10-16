<?php

use App\Http\Controllers\ContactLeadController;
use Illuminate\Support\Str;
use App\Http\Controllers\Contacts\CONT01Controller;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 * Don't create  resource route
 */

$module = 'Contacts';
$model = 'CONT01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// CLIENT
Route::post($route.'/send', [ContactLeadController::class, 'store'])->name($routeName.'.store');
Route::get($route.'/confirmacao-contato', [CONT01Controller::class, 'confirmation'])->name($routeName.'.confirmation');
