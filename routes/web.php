<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

View::composer('Client.Core.client', function ($view) {
    $renderCore = new CoreController();
    return $view->with('renderFooter', $renderCore->renderFooter())->with('renderHeader', $renderCore->renderHeader());
});

Route::get('/painel', function(){
    return view('Admin.dashboard');
})->name('admin.dashboard');

Route::get('/', 'HomePageController@index')->name('home');

// INSERT ROUTES
$modelsMain = config('modelsConfig.InsertModelsMain');
foreach ($modelsMain as $module => $model) {
    $modelLw = Str::lower($model->Code);
    include_once "{$module}/{$modelLw}.php";
}

