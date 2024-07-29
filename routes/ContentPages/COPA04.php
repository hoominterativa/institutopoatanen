<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentPages\COPA04Controller;
use App\Models\ContentPages\COPA04ContentPagesSectionHero;
use App\Http\Controllers\ContentPages\COPA04SectionHeroController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'ContentPages';
$model = 'COPA04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/copa04', COPA04Controller::class)->names('admin.'.$routeName.'.index')->parameters(['copa04' => 'COPA04ContentPages']);

    Route::resource($route.'/sectionHero', COPA04SectionHeroController::class)->names('admin.'.$routeName.'.sectionHero')->parameters(['sectionHero' => 'COPA04ContentPagesSectionHero']);
    Route::post($route.'/sectionHero/delete', [COPA04SectionHeroController::class, 'destroySelected'])->name('admin.'.$routeName.'.sectionHero.destroySelected');
    Route::post($route.'/sectionHero/sorting', [COPA04SectionHeroController::class, 'sorting'])->name('admin.'.$routeName.'.sectionHero.sorting');
});
// // CLIENT
// Route::get($route.'/teste', [COPA04Controller::class, 'page'])->name($routeName.'.page');
