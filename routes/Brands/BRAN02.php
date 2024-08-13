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
 Route::resource($route.'/secao', BRAN02Controller::class)->names('admin.'.$routeName.'.category')->parameters(['secao' => 'BRAN02Brands']);
  Route::post($route.'/secao/delete', [BRAN02Controller::class, 'destroySelected'])->name('admin.'.$routeName.'.secao.destroySelected');
  Route::post($route.'/secao/sorting', [BRAN02Controller::class, 'sorting'])->name('admin.'.$routeName.'.secao.sorting');
  Route::post($route.'/marcas/{BRAN02Brands}', [BRAN02Controller::class, 'show'])->name('admin.'.$routeName.'.  ');

  //Produtos
  Route::resource($route.'/products', BRAN02productsController::class)->names('admin.'.$routeName.'.products')->parameters(['products' => 'BRAN02BrandsProducts']);
  Route::post($route.'/products/delete', [BRAN02productsController::class, 'destroySelected'])->name('admin.'.$routeName.'.products.destroySelected');
  Route::post($route.'/products/sorting', [BRAN02productsController::class, 'sorting'])->name('admin.'.$routeName.'.products.sorting');

  //Categoria
  Route::resource($route.'/categorie', BRAN02SectionController::class)->names('admin.'.$routeName.'.categories')->parameters(['categorie' => 'BRAN02BrandsSection']);
  Route::post($route.'/categorie/delete', [BRAN02SectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.categorie.destroySelected');
  Route::post($route.'/categorie/sorting', [BRAN02SectionController::class, 'sorting'])->name('admin.'.$routeName.'.categorie.sorting');

 });
//  CLIENT
 Route::get($route.'/{id}', [BRAN02Controller::class, 'show'])->name($routeName.'.show');
