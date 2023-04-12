<?php

use App\Http\Controllers\ContentPages\COPA02SectionContentController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'ContentPages';
$model = 'COPA02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/secao', COPA02SectionContentController::class)->names('admin.'.$routeName.'.section.content')->parameters(['secao' => 'COPA02ContentPagesSectionContent']);
    Route::post($route.'/secao/delete', [COPA02SectionContentController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.content.destroySelected');
});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
