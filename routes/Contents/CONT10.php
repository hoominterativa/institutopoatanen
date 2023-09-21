<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\Contents\CONT10ContentsSection;
use App\Http\Controllers\Contents\CONT10SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contents';
$model = 'CONT10';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', CONT10SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'CONT10ContentsSection']);
    Route::post($route.'/secao/delete', [CONT10SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');
});
