<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentPages\COPA03TopicController;
use App\Http\Controllers\ContentPages\COPA03VideoController;
use App\Http\Controllers\ContentPages\COPA03CategoryController;
use App\Http\Controllers\ContentPages\COPA03Controller;
use App\Http\Controllers\ContentPages\COPA03SubCategoryTopicController;
use App\Http\Controllers\ContentPages\COPA03SubCategoryVideoController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'ContentPages';
$model = 'COPA03';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', COPA03CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'COPA03ContentPagesCategory']);
    Route::post($route.'/categoria/delete', [COPA03CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [COPA03CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    //
    Route::resource($route.'/subcategoria-topics', COPA03SubCategoryTopicController::class)->names('admin.'.$routeName.'.subcategory-topics')->parameters(['subcategoria-topics' => 'COPA03ContentPagesSubCategoryT']);
    Route::post($route.'/subcategoria-topic/delete', [COPA03SubCategoryTopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.subcategory-topics.destroySelected');
    Route::post($route.'/subcategoria-topic/sorting', [COPA03SubCategoryTopicController::class, 'sorting'])->name('admin.'.$routeName.'.subcategory-topics.sorting');

    //
    Route::resource($route.'/subcategoria-videos', COPA03SubCategoryVideoController::class)->names('admin.'.$routeName.'.subcategory-videos')->parameters(['subcategoria-videos' => 'COPA03ContentPagesSubCategoryV']);
    Route::post($route.'/subcategoria-video/delete', [COPA03SubCategoryVideoController::class, 'destroySelected'])->name('admin.'.$routeName.'.subcategory-videos.destroySelected');
    Route::post($route.'/subcategoria-video/sorting', [COPA03SubCategoryVideoController::class, 'sorting'])->name('admin.'.$routeName.'.subcategory-videos.sorting');

    //
    Route::resource($route.'/topicos', COPA03TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'COPA03ContentPagesTopic']);
    Route::post($route.'/topico/delete', [COPA03TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [COPA03TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    //
    Route::resource($route.'/videos', COPA03VideoController::class)->names('admin.'.$routeName.'.video')->parameters(['videos' => 'COPA03ContentPagesVideo']);
    Route::post($route.'/video/delete', [COPA03VideoController::class, 'destroySelected'])->name('admin.'.$routeName.'.video.destroySelected');
    Route::post($route.'/video/sorting', [COPA03VideoController::class, 'sorting'])->name('admin.'.$routeName.'.video.sorting');
});
// CLIENT
Route::get($route.'/{COPA03ContentPages:slug}/categoria/{COPA03ContentPagesCategory:slug}', [COPA03Controller::class, 'show'])->name($routeName.'.category.page');
Route::get($route.'/{COPA03ContentPages:slug}/categoria/{COPA03ContentPagesCategory:slug}/subcategoria{COPA03ContentPagesSubCategoryT:slug}', [COPA03Controller::class, 'show'])->name($routeName.'.subcategory-topic.page');
Route::get($route.'/{COPA03ContentPages:slug}/categoria/{COPA03ContentPagesCategory:slug}/subcategoria{COPA03ContentPagesSubCategoryV:slug}', [COPA03Controller::class, 'show'])->name($routeName.'.subcategory-video.page');
