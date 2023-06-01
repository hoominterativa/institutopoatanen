<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contacts\COTA02TopicController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contacts';
$model = 'COTA02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/topicos', COTA02TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'COTA02ContactsTopic']);
    Route::post($route.'/topico/delete', [COTA02TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [COTA02TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
