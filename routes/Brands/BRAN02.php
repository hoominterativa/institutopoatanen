<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Brands\BRAN02Controller;
use App\Http\Controllers\Brands\BRAN02SectionController;
use App\Http\Controllers\Brands\BRAN02productsController;

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
 Route::resource($route.'/secao', BRAN02Controller::class)->names('admin.'.$routeName.'.category')->parameters(['secao' => 'BRAN02BrandsSection']);
  Route::post($route.'/secao/delete', [BRAN02Controller::class, 'destroySelected'])->name('admin.'.$routeName.'.secao.destroySelected');
  Route::post($route.'/secao/sorting', [BRAN02Controller::class, 'sorting'])->name('admin.'.$routeName.'.secao.sorting');

  //Produtos
  Route::resource($route.'/categorie', BRAN02productsController::class)->names('admin.'.$routeName.'.categorie')->parameters(['categorie' => 'BRAN02BrandsSection']);
  Route::post($route.'/categorie/delete', [BRAN02productsController::class, 'destroySelected'])->name('admin.'.$routeName.'.products.destroySelected');
  Route::post($route.'/categorie/sorting', [BRAN02productsController::class, 'sorting'])->name('admin.'.$routeName.'.products.sorting');

  //Categoria
  Route::resource($route.'/item', BRAN02SectionController::class)->names('admin.'.$routeName.'.item')->parameters(['secao' => 'BRAN02BrandsSection']);
  Route::post($route.'/item/delete', [BRAN02SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.item.destroySelected');
  Route::post($route.'/item/sorting', [BRAN02SectionController::class, 'sorting'])->name('admin.'.$routeName.'.item.sorting');

 });
//  CLIENT
 Route::get($route.'/teste', [BRAN02Controller::class, 'page'])->name($routeName.'.page');
