<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teams\TEAM01Controller;
use App\Http\Controllers\Teams\TEAM01BannerController;
use App\Http\Controllers\Teams\TEAM01SectionController;
use App\Http\Controllers\Teams\TEAM01CategoryController;
use App\Http\Controllers\Teams\TEAM01SectionTeamController;
use App\Http\Controllers\Teams\TEAM01SocialMediaController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Teams';
$model = 'TEAM01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', TEAM01CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'TEAM01TeamsCategory']);
    Route::post($route.'/categoria/delete', [TEAM01CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [TEAM01CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/sociais', TEAM01SocialMediaController::class)->names('admin.'.$routeName.'.social')->parameters(['sociais' => 'TEAM01TeamsSocialMedia']);
    Route::post($route.'/social/delete', [TEAM01SocialMediaController::class, 'destroySelected'])->name('admin.'.$routeName.'.social.destroySelected');
    Route::post($route.'/social/sorting', [TEAM01SocialMediaController::class, 'sorting'])->name('admin.'.$routeName.'.social.sorting');

    Route::post('busca/'.$route, [TEAM01Controller::class, 'filter'])->name('admin.'.$routeName.'.index.filter');
    Route::get('clearFilter/'.$route, [TEAM01Controller::class, 'clearFilter'])->name('admin.'.$routeName.'.clearFilter');

    Route::resource($route.'/secao', TEAM01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'TEAM01TeamsSection']);

    Route::resource($route.'/secaoteam', TEAM01SectionTeamController::class)->names('admin.'.$routeName.'.sectionteam')->parameters(['secaoteam' => 'TEAM01TeamsSectionTeam']);

    Route::resource($route.'/banner', TEAM01BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'TEAM01TeamsBanner']);
});
// CLIENT
Route::get($route.'/teste', [TEAM01CategoryController::class, 'page'])->name($routeName.'.page');
