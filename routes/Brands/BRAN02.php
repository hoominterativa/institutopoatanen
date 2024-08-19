<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Brands\BRAN02Controller;
use App\Http\Controllers\Brands\BRAN02CategoriesController; 
use App\Http\Controllers\Brands\Bran02MarcasController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

 $module = 'Brands';
 $model = 'BRAN02';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
 Route::resource($route.'/secao', BRAN02Controller::class)->names('admin.'.$routeName.'.category')->parameters(['secao' => 'BRAN02Brands']);
  Route::post($route.'/secao/delete', [BRAN02Controller::class, 'destroySelected'])->name('admin.'.$routeName.'.secao.destroySelected');
  Route::post($route.'/secao/sorting', [BRAN02Controller::class, 'sorting'])->name('admin.'.$routeName.'.secao.sorting');
  Route::post($route.'/marcas/{BRAN02Brands}', [BRAN02Controller::class, 'show'])->name('admin.'.$routeName.'.  ');

  //Produtos
  Route::resource($route.'/marcas', Bran02MarcasController::class)->names('admin.'.$routeName.'.marcas')->parameters(['marcas' => 'BRAN02BrandsMarcas']);
  Route::post($route.'/marcas/delete', [Bran02MarcasController::class, 'destroySelected'])->name('admin.'.$routeName.'.marcas.destroySelected');
  Route::post($route.'/marcas/sorting', [Bran02MarcasController::class, 'sorting'])->name('admin.'.$routeName.'.marcas.sorting');

  //Categoria
  Route::resource($route.'/categorie', BRAN02CategoriesController::class)->names('admin.'.$routeName.'.categories')->parameters(['categorie' => 'BRAN02BrandsCategories']);
  Route::post($route.'/categorie/delete', [BRAN02CategoriesController::class, 'destroySelected'])->name('admin.'.$routeName.'.categories.destroySelected');
  Route::post($route.'/categorie/sorting', [BRAN02CategoriesController::class, 'sorting'])->name('admin.'.$routeName.'.categories.sorting');

 });
//  CLIENT
Route::get($route.'', [BRAN02Controller::class, 'page'])->name('bran02.page');
 Route::get($route.'/{id}', [BRAN02Controller::class, 'show'])->name($routeName.'.show');
