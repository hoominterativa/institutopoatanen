<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
View::composer('Client.Core.client', function ($view) {
    $renderCore = new CoreController();
    return $view->with('renderFooter', $renderCore->renderFooter())->with('renderHeader', $renderCore->renderHeader());
});

Route::get('/', 'HomePageController@index')->name('home');

Route::get('/category', 'CoreController@header');
