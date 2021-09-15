<?php

use Illuminate\Support\Str;
use App\Models\Optimization;
use App\Models\OptimizePage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OptimizationController;
use App\Http\Controllers\OptimizePageController;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

View::composer('Client.Core.client', function ($view) {
    $renderCore = new CoreController();
    $optimization = Optimization::first();
    $optimizePage = OptimizePage::where('page', Request::path())->first();
    return $view->with('renderHeader', $renderCore->renderHeader())
        ->with('renderFooter', $renderCore->renderFooter())
        ->with('optimizePage', $optimizePage)
        ->with('optimization', $optimization);
});

View::composer('Admin.core.admin', function ($view) {
    $modelsMain = collect(config('modelsConfig.InsertModelsMain'));
    return $view->with('modelsMain', $modelsMain);
});

View::composer('Admin.dashboard', function ($view) {
    $modelsMain = collect(config('modelsConfig.InsertModelsMain'));
    return $view->with('modelsMain', $modelsMain);
});

Route::prefix('painel')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('otimizacao', OptimizationController::class)->names('admin.optimization')->parameters(['otimizacao' => 'optimization']);
    Route::resource('otimizar-pagina', OptimizePageController::class)->names('admin.optimizePage')->parameters(['otimizar-pagina' => 'optimizePage']);
    Route::post('otimizar-pagina/delete', [OptimizePageController::class, 'destroySelected'])->name('admin.optimizePage.destroySelected');
});


Route::get('/', [HomePageController::class ,'index'])->name('home');



// INSERT ROUTES
$modelsMain = config('modelsConfig.InsertModelsMain');
foreach ($modelsMain as $module => $models) {
    foreach ($models as $code => $model) {
        $modelLw = Str::lower($code);
        include_once "{$module}/{$modelLw}.php";
    }
}
