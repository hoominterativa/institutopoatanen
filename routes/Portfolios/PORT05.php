<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portfolios\PORT05CategoryController;
use App\Models\Portfolios\PORT05Portfolios;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Portfolios';
$model = 'PORT05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', PORT05CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PORT05PortfoliosCategory']);
    Route::post($route.'/categoria/delete', [PORT05CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PORT05CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::get('/teste', function() {
        $portfolio = PORT05Portfolios::find(1);
        // $portfolio->categories->get();
        dd($portfolio->categories->get());
    });
});
// CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
