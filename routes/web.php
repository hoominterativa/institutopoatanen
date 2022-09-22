<?php

use Illuminate\Support\Str;
use App\Models\Optimization;
use App\Models\OptimizePage;
use App\Models\SettingTheme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\ContactLeadController;
use App\Http\Controllers\OptimizationController;
use App\Http\Controllers\OptimizePageController;
use App\Http\Controllers\SettingThemeController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\NewsletterLeadController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Models\GeneralSetting;
use App\Models\Social;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

View::composer('Client.Core.client', function ($view) {
    $renderCore = new CoreController();
    $optimization = Optimization::first();
    $optimizePage = OptimizePage::where('page', Request::path())->first();
    $generalSetting = GeneralSetting::first();
    $socials = Social::orderBy('sorting', 'ASC')->get();
    $themeMenu = config('modelsConfig.InsertModelsCore');
    $coreRender = new CoreController();
    $listMenu = $coreRender->relationsHeaderMenu();

    return $view->with('renderHeader', $renderCore->renderHeader())
        ->with('renderFooter', $renderCore->renderFooter())
        ->with('optimizePage', $optimizePage)
        ->with('optimization', $optimization)
        ->with('socials', $socials)
        ->with('themeMenu', $themeMenu->Headers->themeMenu??null)
        ->with('listMenu', $listMenu)
        ->with('generalSetting', $generalSetting);
});

View::composer('Admin.core.auth', function ($view) {
    $generalSetting = GeneralSetting::first();
    return $view->with('generalSetting', $generalSetting);
});

View::composer('Admin.core.admin', function ($view) {

    $modelsMain = collect(config('modelsConfig.InsertModelsMain'));
    $settingTheme = SettingTheme::where('user_id', Auth::user()->id)->first();
    $generalSetting = GeneralSetting::first();
    return $view->with('modelsMain', $modelsMain)->with('settingTheme', $settingTheme)->with('generalSetting', $generalSetting);
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
        Route::post('otimizar-pagina/sorting', [OptimizePageController::class, 'sorting'])->name('admin.optimizePage.sorting');
        Route::post('otimizar-pagina/delete', [OptimizePageController::class, 'destroySelected'])->name('admin.optimizePage.destroySelected');

        // LOGOUT
        Route::get('logout', [UserAuthController::class, 'logout'])->name('admin.user.logout');

        // ICONS
        Route::get('icones', function(){
            return view('Admin.icons');
        })->name('admin.icons');

        // GENERAL SETTING
        Route::resource('configuracoes-gerais', GeneralSettingController::class)->names('admin.generalSetting')->parameters(['configuracoes-gerais' => 'GeneralSetting']);

        // SOCIAL
        Route::resource('social', SocialController::class)->names('admin.social')->parameters(['social' => 'Social']);
        Route::post('social/delete', [SocialController::class, 'destroySelected'])->name('admin.social.destroySelected');
        Route::post('social/sorting', [SocialController::class, 'sorting'])->name('admin.social.sorting');

        // LEAD CONTACT
        Route::resource('contatos', ContactLeadController::class)->names('admin.contact')->parameters(['contato' => 'ContactLead']);

        // LEAD NEWSLETTER
        Route::get('newsletter', [NewsletterLeadController::class, 'index'])->name('admin.newsletter.index');

        // SETTING FORM CONTACT
        Route::resource('configuracao-formulario', ContactFormController::class)->names('admin.contactForm')->parameters(['configuracao-formulario' => 'ContactForm']);
        Route::post('configuracao-formulario/delete', [ContactFormController::class, 'destroySelected'])->name('admin.contactForm.destroySelected');
    });
});

Route::get('/home', [HomePageController::class ,'index'])->name('home');
Route::get('/', function(){return redirect()->route('home');});

/**
 *
 * Send from core view general settings and social
 *
 */

$modelsCore = config('modelsConfig.InsertModelsCore');
if(isset($modelsCore->Headers->Code)){
    View::composer('Client.Core.Headers.'.$modelsCore->Headers->Code.'.app', function ($view) {
        $generalSetting = GeneralSetting::first();
        $socials = Social::get();
        return $view->with('generalSetting', $generalSetting)->with('socials', $socials);
    });
}
if(isset($modelsCore->Footers->Code)){
    View::composer('Client.Core.Footers.'.$modelsCore->Footers->Code.'.app', function ($view) {
        $generalSetting = GeneralSetting::first();
        $socials = Social::get();
        return $view->with('generalSetting', $generalSetting)->with('socials', $socials);
    });
}

/**
 *
 * Create essential routes according to the configurations of modules and templates
 * to create new routes, insert them into your template's web file
 *
 */

$class = config('modelsClass.Class');
$modelsMain = config('modelsConfig.InsertModelsMain');
foreach ($modelsMain as $module => $models) {
    $module = explode('.', $module)[0];
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
