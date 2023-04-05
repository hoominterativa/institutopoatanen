<?php

use App\Models\Contents\CONT10ContentsSection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

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
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', CONT10ContentsSection::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'CONT10ContentsSection']);
    Route::post($route.'/secao/delete', [CONT10ContentsSection::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
