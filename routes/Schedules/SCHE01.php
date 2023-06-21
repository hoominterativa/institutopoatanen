<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schedules\SCHE01BannerController;
use App\Http\Controllers\Schedules\SCHE01BannerShowController;
use App\Http\Controllers\Schedules\SCHE01SectionScheduleController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Schedules';
$model = 'SCHE01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', TEST01Controller::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT01PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [TEST01Controller::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [TEST01Controller::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/banner', SCHE01BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'SCHE01SchedulesBanner']);
    Route::resource($route.'/banner-show', SCHE01BannerShowController::class)->names('admin.'.$routeName.'.bannershow')->parameters(['banner-show' => 'SCHE01SchedulesBannerShow']);
    Route::resource($route.'/secao-agenda', SCHE01SectionScheduleController::class)->names('admin.'.$routeName.'.sectionschedule')->parameters(['secao-agenda' => 'SCHE01SchedulesSectionSchedule']);

});
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
