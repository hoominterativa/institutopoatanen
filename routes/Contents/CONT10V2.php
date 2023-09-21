<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contents\CONT10V2SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

 $module = 'Contents';
 $model = 'CONT10V2';

 $class = config('modelsConfig.Class');
 $modelConfig = config('modelsConfig.InsertModelsMain');
 $module = getNameModule($modelConfig, $module, $model);
 $modelConfig = $modelConfig->$module->$model->config;

 $route = Str::slug($modelConfig->titlePanel);
 $routeName = Str::lower($model);

 // ADMIN
 Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
     Route::resource($route.'/secao', CONT10V2SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'CONT10V2ContentsSection']);
     Route::post($route.'/secao/delete', [CONT10V2SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');
 });
