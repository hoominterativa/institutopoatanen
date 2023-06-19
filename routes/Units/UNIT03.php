<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Units\UNIT03Controller;
use App\Http\Controllers\Units\UNIT03TopicController;
use App\Http\Controllers\Units\UNIT03BannerController;
use App\Http\Controllers\Units\UNIT03SocialController;
use App\Http\Controllers\Units\UNIT03ContentController;
use App\Http\Controllers\Units\UNIT03GalleryController;
use App\Http\Controllers\Units\UNIT03CategoryController;
use App\Http\Controllers\Units\UNIT03BannerShowController;
use App\Http\Controllers\Units\UNIT03GalleryContentController;
use App\Http\Controllers\Units\UNIT03SectionGalleryController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Units';
$model = 'UNIT03';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', UNIT03CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'UNIT03UnitsCategory']);
    Route::post($route.'/categoria/delete', [UNIT03CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [UNIT03CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/topicos', UNIT03TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topicos' => 'UNIT03UnitsTopic']);
    Route::post($route.'/topico/delete', [UNIT03TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [UNIT03TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    Route::resource($route.'/sociais', UNIT03SocialController::class)->names('admin.'.$routeName.'.social')->parameters(['sociais' => 'UNIT03UnitsSocial']);
    Route::post($route.'/social/delete', [UNIT03SocialController::class, 'destroySelected'])->name('admin.'.$routeName.'.social.destroySelected');
    Route::post($route.'/social/sorting', [UNIT03SocialController::class, 'sorting'])->name('admin.'.$routeName.'.social.sorting');

    Route::resource($route.'/conteudos', UNIT03ContentController::class)->names('admin.'.$routeName.'.content')->parameters(['conteudos' => 'UNIT03UnitsContent']);
    Route::post($route.'/conteudo/delete', [UNIT03ContentController::class, 'destroySelected'])->name('admin.'.$routeName.'.content.destroySelected');
    Route::post($route.'/conteudo/sorting', [UNIT03ContentController::class, 'sorting'])->name('admin.'.$routeName.'.content.sorting');

    Route::resource($route.'/galerias', UNIT03GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galerias' => 'UNIT03UnitsGallery']);
    Route::post($route.'/galeria/delete', [UNIT03GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [UNIT03GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');

    Route::resource($route.'/galeriacontents', UNIT03GalleryContentController::class)->names('admin.'.$routeName.'.galleryContent')->parameters(['galeriacontents' => 'UNIT03UnitsGalleryContent']);
    Route::post($route.'/galeriacontent/delete', [UNIT03GalleryContentController::class, 'destroySelected'])->name('admin.'.$routeName.'.galleryContent.destroySelected');
    Route::post($route.'/galeriacontent/sorting', [UNIT03GalleryContentController::class, 'sorting'])->name('admin.'.$routeName.'.galleryContent.sorting');

    Route::resource($route.'/banner', UNIT03BannerController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'UNIT03UnitsBanner']);

    Route::resource($route.'/secao-galeria', UNIT03SectionGalleryController::class)->names('admin.'.$routeName.'.section')->parameters(['secao-galeria' => 'UNIT03UnitsSectionGallery']);

    Route::resource($route.'/bannershow', UNIT03BannerShowController::class)->names('admin.'.$routeName.'.bannerShow')->parameters(['bannershow' => 'UNIT03UnitsBannerShow']);
});
// // CLIENT
Route::get($route.'/categoria/{UNIT03UnitsCategory:slug}', [UNIT03Controller::class, 'page'])->name($routeName.'.category.page');
Route::get('categoria/{UNIT03UnitsCategory:slug}/'.$route.'/{UNIT03Units:slug}', [UNIT03Controller::class, 'show'])->name($routeName.'.page.content');
