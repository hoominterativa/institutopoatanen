<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contacts\COTA04FormController;
use App\Http\Controllers\Contacts\COTA04SectionController;
use App\Http\Controllers\Contacts\COTA04CategoryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Contacts';
$model = 'COTA04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Categories
    Route::resource($route.'/categorias', COTA04CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'COTA04ContactsCategory']);
    Route::post($route.'/categoria/delete', [COTA04CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [COTA04CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    //Forms
    Route::resource($route.'/formularios', COTA04FormController::class)->names('admin.'.$routeName.'.form')->parameters(['formularios' => 'COTA04ContactsForm']);
    Route::post($route.'/formulario/delete', [COTA04FormController::class, 'destroySelected'])->name('admin.'.$routeName.'.form.destroySelected');
    Route::post($route.'/formulario/sorting', [COTA04FormController::class, 'sorting'])->name('admin.'.$routeName.'.form.sorting');

    //Sections
    Route::resource($route.'/secoes', COTA04SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secoes' => 'COTA04ContactsSection']);
    Route::get($route.'/secao/{COTA04Contacts}/create', [COTA04SectionController::class, 'create'])->name('admin.'.$routeName.'.section.create');
    Route::post($route.'/secao/delete', [COTA04SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.section.destroySelected');
    Route::post($route.'/secao/sorting', [COTA04SectionController::class, 'sorting'])->name('admin.'.$routeName.'.section.sorting');
});
