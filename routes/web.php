<?php

use Illuminate\Support\Str;
use App\Models\SettingTheme;
use Illuminate\Support\Facades\Auth;
use App\Models\Optimization;
use App\Models\OptimizePage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingThemeController;
use App\Http\Controllers\User\AuthController as UserAuthController;
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
    $settingTheme = SettingTheme::where('user_id', Auth::user()->id)->first();
    return $view->with('modelsMain', $modelsMain)->with('settingTheme', $settingTheme);
});

View::composer('Admin.dashboard', function ($view) {
    $modelsMain = collect(config('modelsConfig.InsertModelsMain'));
    return $view->with('modelsMain', $modelsMain);
});

Route::prefix('painel')->group(function () {
    Route::get('login', [UserAuthController::class, 'index'])->name('admin.user.login');
    Route::post('login.do', [UserAuthController::class, 'authenticate'])->name('admin.user.authenticate');

    Route::middleware('auth')->group(function () {
        // DASHBOARD
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // CRUD USER
        Route::resource('usuarios', UserController::class)->names('admin.user')->parameters(['usuarios' => 'user']);
        Route::post('usuarios/delete', [UserController::class, 'destroySelected'])->name('admin.user.destroySelected');
        Route::post('usuarios/sorting', [UserController::class, 'sorting'])->name('admin.user.sorting');

        // SETTINGS THEME
        Route::post('setting', [SettingThemeController::class, 'setting'])->name('admin.settingTheme');

        // CRUD SEO
        Route::resource('otimizacao', OptimizationController::class)->names('admin.optimization')->parameters(['otimizacao' => 'optimization']);
        Route::resource('otimizar-pagina', OptimizePageController::class)->names('admin.optimizePage')->parameters(['otimizar-pagina' => 'optimizePage']);
        Route::post('otimizar-pagina/delete', [OptimizePageController::class, 'destroySelected'])->name('admin.optimizePage.destroySelected');

        // LOGOUT
        Route::get('logout', [UserAuthController::class, 'logout'])->name('admin.user.logout');

        // ICONS
        Route::get('icones', function(){
            return view('Admin.icons');
        });
    });
});

Route::get('/', [HomePageController::class ,'index'])->name('home');

/**
 *
 * Create essential routes according to the configurations of modules and templates
 * to create new routes, insert them into your template's web file
 *
 */

$class = config('modelsConfig.Class');
$modelsMain = config('modelsConfig.InsertModelsMain');
foreach ($modelsMain as $module => $models) {
    foreach ($models as $code => $model) {
        $modelConfig = $model->config;

        $route = Str::slug($modelConfig->titlePanel);
        $routeName = Str::lower($code);
        $controller = $class->$module->$code->controller;
        $parameters = $code.$module;

        // ADMIN
        Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $controller, $routeName, $parameters){
            Route::resource($route, $controller)->names('admin.'.$routeName)->parameters([$route => $parameters]);
            Route::post($route.'/delete', [$controller, 'destroySelected'])->name('admin.'.$routeName.'.destroySelected');
            Route::post($route.'/sorting', [$controller, 'sorting'])->name('admin.'.$routeName.'.sorting');
        });

        // CLIENT
        Route::get($route, [$controller, 'page'])->name($routeName.'.page');
        Route::get($route.'/{'.$parameters.'}', [$controller, 'show'])->name($routeName.'.show');

        include_once "{$module}/{$code}.php";
    }
}
