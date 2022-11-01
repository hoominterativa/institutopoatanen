<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV01SectionController;
use App\Http\Controllers\Services\SERV01AdvantageController;
use App\Http\Controllers\Services\SERV01PortfolioController;
use App\Http\Controllers\Services\SERV01AdvantageSectionController;
use App\Http\Controllers\Services\SERV01PortfolioSectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV01';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/informacoes-secao', SERV01SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['informacoes-secao' => 'SERV01ServicesSection']);

    Route::resource($route.'/vantagens', SERV01AdvantageController::class)->names('admin.'.$routeName.'.advantage')->parameters(['vantagens' => 'SERV01ServicesAdvantage']);
    Route::post($route.'/vantagens/delete', [SERV01AdvantageController::class, 'destroySelected'])->name('admin.'.$routeName.'.advantage.destroySelected');
    Route::post($route.'/vantagens/sorting', [SERV01AdvantageController::class, 'sorting'])->name('admin.'.$routeName.'.advantage.sorting');
    Route::resource($route.'/vantagens/informacoes-secao', SERV01AdvantageSectionController::class)->names('admin.'.$routeName.'.advantage.section')->parameters(['informacoes-secao' => 'SERV01ServicesAdvantageSection']);

    Route::resource($route.'/portifolios', SERV01PortfolioController::class)->names('admin.'.$routeName.'.portfolio')->parameters(['vantagens' => 'SERV01ServicesPortfolio']);
    Route::post($route.'/portifolios/delete', [SERV01PortfolioController::class, 'destroySelected'])->name('admin.'.$routeName.'.portfolio.destroySelected');
    Route::post($route.'/portifolios/sorting', [SERV01PortfolioController::class, 'sorting'])->name('admin.'.$routeName.'.portfolio.sorting');
    Route::resource($route.'/portifolios/informacoes-secao', SERV01PortfolioSectionController::class)->names('admin.'.$routeName.'.portfolio.section')->parameters(['informacoes-secao' => 'SERV01ServicesPortfolioSection']);
});
// CLIENT
// Route::get($route.'/teste', [TEST01Controller::class, 'page'])->name($routeName.'.page');
