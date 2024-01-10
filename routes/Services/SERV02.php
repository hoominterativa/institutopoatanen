<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV02Controller;
use App\Http\Controllers\Services\SERV02TopicController;
use App\Http\Controllers\Services\SERV02SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Topics
    Route::resource($route.'/topicos', SERV02TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'SERV02ServicesTopic']);
    Route::post($route.'/topico/delete', [SERV02TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [SERV02TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    //Sections: Home && Banner page
    Route::resource($route.'/secao', SERV02SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'SERV02ServicesSection']);
});
// CLIENT
Route::get($route.'/{SERV02Services:slug}', [SERV02Controller::class, 'show'])->name($routeName.'.page.content');
