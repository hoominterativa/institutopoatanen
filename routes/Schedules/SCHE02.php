<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\Schedules\SCHE02Schedules;
use App\Http\Controllers\Schedules\SCHE02Controller;
use App\Http\Controllers\Schedules\SCHE02SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Schedules';
$model = 'SCHE02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', SCHE02SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SCHE02SchedulesSection']);
    Route::resource($route.'/banner', SCHE02SectionController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'SCHE02SchedulesSection']);
});
// CLIENT
Route::post('/SCHE02/getEvents', [SCHE02Controller::class, 'show'])->name($routeName.'.getEvents');
