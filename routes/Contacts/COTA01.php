<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\Contacts\COTA01ContactsTopicForm;
use App\Http\Controllers\Contacts\COTA01TopicController;
use App\Http\Controllers\Contacts\COTA01TopicFormController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contacts';
$model = 'COTA01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/topicos-formulario', COTA01TopicFormController::class)->names('admin.'.$routeName.'.topicForm')->parameters(['topicos-formulario' => 'COTA01ContactsTopicForm']);
    Route::post($route.'/topicos-formulario/delete', [COTA01TopicFormController::class, 'destroySelected'])->name('admin.'.$routeName.'.topicForm.destroySelected');
    Route::post($route.'/topicos-formulario/sorting', [COTA01TopicFormController::class, 'sorting'])->name('admin.'.$routeName.'.topicForm.sorting');

    Route::resource($route.'/topicos-secao', COTA01TopicController::class)->names('admin.'.$routeName.'.topicSection')->parameters(['topicos-secao' => 'COTA01ContactsTopic']);
    Route::post($route.'/topicos-secao/delete', [COTA01TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topicSection.destroySelected');
    Route::post($route.'/topicos-secao/sorting', [COTA01TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topicSection.sorting');
});
// CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
