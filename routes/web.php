<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\AuthController as UserAuthController;

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

Route::prefix('painel')->group(function () {
    Route::get('login', [UserAuthController::class, 'index'])->name('admin.user.login');
    Route::get('login.do', [UserAuthController::class, 'authentication'])->name('admin.user.authentication');

    Route::middleware('user')->group(function () {

    });

    Route::resource('usuarios', UserController::class)->names('admin.user')->parameters(['usuarios' => 'user']);
    Route::post('usuarios/delete', [UserController::class, 'destroySelected'])->name('admin.user.destroySelected');
    Route::post('usuarios/sorting', [UserController::class, 'sorting'])->name('admin.user.sorting');
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [UserAuthController::class, 'logout'])->name('admin.user.logout');
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
