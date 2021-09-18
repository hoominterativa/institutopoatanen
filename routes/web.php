<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

View::composer('Client.Core.client', function ($view) {
    $renderCore = new CoreController();
    return $view->with('renderHeader', $renderCore->renderHeader())->with('renderFooter', $renderCore->renderFooter());
});

View::composer('Admin.core.admin', function ($view) {
    $modelsMain = collect(config('modelsConfig.InsertModelsMain'));
    return $view->with('modelsMain', $modelsMain);
});

View::composer('Admin.dashboard', function ($view) {
    $modelsMain = collect(config('modelsConfig.InsertModelsMain'));
    return $view->with('modelsMain', $modelsMain);
});

Route::get('/painel', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/painel/create', [DashboardController::class, 'create'])->name('admin.dashboard.create');
Route::get('/', [HomePageController::class ,'index'])->name('home');

// INSERT ROUTES
$modelsMain = config('modelsConfig.InsertModelsMain');
foreach ($modelsMain as $module => $models) {
    foreach ($models as $code => $model) {
        $modelLw = Str::lower($code);
        include_once "{$module}/{$modelLw}.php";
    }
}
