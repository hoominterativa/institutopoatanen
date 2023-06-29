<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\PROD05Controller;
use App\Http\Controllers\Products\PROD05TopicController;
use App\Http\Controllers\Products\PROD05GalleryController;
use App\Http\Controllers\Products\PROD05SectionController;
use App\Http\Controllers\Products\PROD05CategoryController;
use App\Http\Controllers\Products\PROD05GalleryTypeController;
use App\Http\Controllers\Products\PROD05SubcategoryController;
use App\Http\Controllers\Products\PROD05TopicCategoryController;
use App\Http\Controllers\Products\PROD05GallerySectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Products';
$model = 'PROD05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/categorias', PROD05CategoryController::class)->names('admin.'.$routeName.'.category')->parameters(['categorias' => 'PROD05ProductsCategory']);
    Route::post($route.'/categoria/delete', [PROD05CategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.category.destroySelected');
    Route::post($route.'/categoria/sorting', [PROD05CategoryController::class, 'sorting'])->name('admin.'.$routeName.'.category.sorting');

    Route::resource($route.'/subcategorias', PROD05SubcategoryController::class)->names('admin.'.$routeName.'.subcategory')->parameters(['subcategorias' => 'PROD05ProductsSubcategory']);
    Route::post($route.'/subcategoria/delete', [PROD05SubcategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.subcategory.destroySelected');
    Route::post($route.'/subcategoria/sorting', [PROD05SubcategoryController::class, 'sorting'])->name('admin.'.$routeName.'.subcategory.sorting');

    Route::resource($route.'/topico-categoria', PROD05TopicCategoryController::class)->names('admin.'.$routeName.'.topicCategory')->parameters(['topico-categoria' => 'PROD05ProductsTopicCategory']);
    Route::post($route.'/topico-categoria/delete', [PROD05TopicCategoryController::class, 'destroySelected'])->name('admin.'.$routeName.'.topicCategory.destroySelected');
    Route::post($route.'/topico-categoria/sorting', [PROD05TopicCategoryController::class, 'sorting'])->name('admin.'.$routeName.'.topicCategory.sorting');

    Route::resource($route.'/topico', PROD05TopicController::class)->names('admin.'.$routeName.'.topic')->parameters(['topico' => 'PROD05ProductsTopic']);
    Route::post($route.'/topico/delete', [PROD05TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topico/sorting', [PROD05TopicController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');

    Route::resource($route.'/tipo-galeria', PROD05GalleryTypeController::class)->names('admin.'.$routeName.'.galleryType')->parameters(['tipo-galeria' => 'PROD05ProductsGalleryType']);
    Route::post($route.'/tipo-galeria/delete', [PROD05GalleryTypeController::class, 'destroySelected'])->name('admin.'.$routeName.'.galleryType.destroySelected');
    Route::post($route.'/tipo-galeria/sorting', [PROD05GalleryTypeController::class, 'sorting'])->name('admin.'.$routeName.'.galleryType.sorting');

    Route::resource($route.'/galeria', PROD05GalleryController::class)->names('admin.'.$routeName.'.gallery')->parameters(['galeria' => 'PROD05ProductsGallery']);
    Route::post($route.'/galeria/delete', [PROD05GalleryController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallery.destroySelected');
    Route::post($route.'/galeria/sorting', [PROD05GalleryController::class, 'sorting'])->name('admin.'.$routeName.'.gallery.sorting');
    Route::post($route.'/galeria/changeList/{PROD05ProductsGallery}', [PROD05GalleryController::class, 'changeList'])->name('admin.'.$routeName.'.changeList');
    Route::post($route.'/getGalleryColor', [PROD05GalleryController::class, 'getGallery'])->name('admin.'.$routeName.'.getGallery');

    Route::resource($route.'/galeria-secao', PROD05GallerySectionController::class)->names('admin.'.$routeName.'.gallerySection')->parameters(['galeria-secao' => 'PROD05ProductsGallerySection']);
    Route::post($route.'/galeria-secao/delete', [PROD05GallerySectionController::class, 'destroySelected'])->name('admin.'.$routeName.'.gallerySection.destroySelected');
    Route::post($route.'/galeria-secao/sorting', [PROD05GallerySectionController::class, 'sorting'])->name('admin.'.$routeName.'.gallerySection.sorting');
    Route::post($route.'/galeria-secao/changeList/{PROD05ProductsGallerySection}', [PROD05GallerySectionController::class, 'changeList'])->name('admin.'.$routeName.'.gallerySection.changeList');

    Route::post($route.'/section', [PROD05SectionController::class, 'sectionStore'])->name('admin.'.$routeName.'.section.store');
    Route::put($route.'/section/{PROD05ProductsSection}', [PROD05SectionController::class, 'sectionUpdate'])->name('admin.'.$routeName.'.section.update');


    Route::post($route.'/banner', [PROD05SectionController::class, 'bannerStore'])->name('admin.'.$routeName.'.banner.store');
    Route::put($route.'/banner/{PROD05ProductsSection}', [PROD05SectionController::class, 'bannerUpdate'])->name('admin.'.$routeName.'.banner.update');

    Route::put($route.'/banner-produto/{PROD05Products}', [PROD05Controller::class, 'bannerUpdate'])->name('admin.'.$routeName.'.bannerProduct.update');

    Route::put($route.'/section-topic/{PROD05Products}', [PROD05Controller::class, 'topicUpdate'])->name('admin.'.$routeName.'.topicSection.update');

});

// CLIENT
Route::get($route.'/categoria/{PROD05ProductsCategory:slug}', [PROD05Controller::class, 'page'])->name($routeName.'.category.page');
Route::get($route.'/categoria/{PROD05ProductsCategory:slug}/subcategoria/{PROD05ProductsSubcategory:slug}', [PROD05Controller::class, 'page'])->name($routeName.'.subcategory.page');
Route::get('categoria/{PROD05ProductsCategory:slug}/subcategoria/{PROD05ProductsSubcategory:slug}/'.$route.'/{PROD05Products:slug}', [PROD05Controller::class, 'show'])->name($routeName.'.page.content');
