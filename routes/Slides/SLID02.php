<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Slides\SLID02TopicController;


/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Slides';
$model = 'SLID02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// // ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName) {
    Route::resource($route . '/topico', SLID02TopicController::class)->names('admin.' . $routeName . '.topic')->parameters(['topico' => 'SLID02SlidesTopic']);
    Route::post($route . '/topico/delete', [SLID02TopicController::class, 'destroySelected'])->name('admin.' . $routeName . '.topic.destroySelected');

    Route::post($route . '/topico/sorting', [SLID02TopicController::class, 'sorting'])->name('admin.' . $routeName . '.topic.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
