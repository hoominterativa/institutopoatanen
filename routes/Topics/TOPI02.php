<?php

use App\Http\Controllers\Topics\TOPI02SectionController;
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
$model = 'TOPI02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', TOPI02SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'TOPI02TopicsSection']);
    Route::post($route.'/secao/delete', [TOPI02SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');
});
// CLIENT
// Route::get($route.'/teste', [TEST02Controller::class, 'page'])->name($routeName.'.page');
