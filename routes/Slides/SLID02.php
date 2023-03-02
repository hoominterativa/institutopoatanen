<?php

use App\Models\Slides\SLID02SlidesSection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

// $module = 'Slides';
// $model = 'SLID02';

// $class = config('modelsConfig.Class');
// $modelConfig = config('modelsConfig.InsertModelsMain');
// $modelConfig = $modelConfig->$module->$model->config;

// $route = Str::slug($modelConfig->titlePanel);
// $routeName = Str::lower($model);

// // // ADMIN
// Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName) {
//     Route::resource($route . '/secao', SLID02SlidesSection::class)->names('admin.' . $routeName . '.section')->parameters(['secao' => 'SLID02SlidesSection']);
//     Route::post($route . '/secao/delete', [SLID02SlidesSection::class, 'destroySelected'])->name('admin.' . $routeName . '.section.destroySelected');
//     Route::post($route . '/categoria/sorting', [SLID02SlidesSection::class, 'sorting'])->name('admin.' . $routeName . '.category.sorting');
// });
// // CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
