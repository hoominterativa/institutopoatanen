<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\ContentPages\COPA04ContentPagesTopic;
use App\Http\Controllers\ContentPages\COPA04Controller;
use App\Models\ContentPages\COPA04ContentPagesSectionHero;
use App\Http\Controllers\ContentPages\COPA04TopicController;
use App\Http\Controllers\ContentPages\COPA04TopicItemController;
use App\Http\Controllers\ContentPages\COPA04SectionHeroController;
use App\Http\Controllers\ContentPages\COPA04SectionVideoController;
use App\Http\Controllers\ContentPages\COPA04TopiccarouselController;
use App\Http\Controllers\ContentPages\COPA04SectionHighlightedController;
use App\Http\Controllers\ContentPages\COPA04Topiccarousel_cardsController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'ContentPages';
$model = 'COPA04';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    Route::resource($route.'/copa04', COPA04Controller::class)->names('admin.'.$routeName.'.index')->parameters(['copa04' => 'COPA04ContentPages']);

    Route::resource($route.'/sectionHero', COPA04SectionHeroController::class)->names('admin.'.$routeName.'.sectionHero')->parameters(['sectionHero' => 'COPA04ContentPagesSectionHero']);
    Route::post($route.'/sectionHero/delete', [COPA04SectionHeroController::class, 'destroySelected'])->name('admin.'.$routeName.'.sectionHero.destroySelected');
    Route::post($route.'/sectionHero/sorting', [COPA04SectionHeroController::class, 'sorting'])->name('admin.'.$routeName.'.sectionHero.sorting');
    
    Route::resource($route.'/sectionVideo', COPA04SectionVideoController::class)->names('admin.'.$routeName.'.sectionVideo')->parameters(['sectionVideo' => 'COPA04ContentPagesSectionVideo']);
    Route::post($route.'/sectionVideo/delete', [COPA04SectionVideoController::class, 'destroySelected'])->name('admin.'.$routeName.'.sectionVideo.destroySelected');
    
    Route::resource($route.'/sectionHighlighted', COPA04SectionHighlightedController::class)->names('admin.'.$routeName.'.sectionHighlighted')->parameters(['sectionHighlighted' => 'COPA04SectionHighlighted']);
    Route::post($route.'/sectionHighlighted/delete', [COPA04SectionHighlightedController::class, 'destroySelected'])->name('admin.'.$routeName.'.sectionHighlighted.destroySelected');
    Route::post($route.'/sectionHighlighted/sorting', [COPA04SectionHighlightedController::class, 'sorting'])->name('admin.'.$routeName.'.sectionHighlighted.sorting');

    Route::resource($route.'/sectionTopic', COPA04TopicController::class)->names('admin.'.$routeName.'.sectionTopic')->parameters(['sectionTopic' => 'COPA04ContentPagesTopic']);
    Route::post($route.'/sectionTopic/delete', [COPA04TopicController::class, 'destroySelected'])->name('admin.'.$routeName.'.sectionTopic.destroySelected');

    Route::resource($route.'/topic', COPA04TopicItemController::class)->names('admin.'.$routeName.'.topic')->parameters(['topic' => 'COPA04ContentPagesTopicItem']);
    Route::post($route.'/topic/delete', [COPA04TopicItemController::class, 'destroySelected'])->name('admin.'.$routeName.'.topic.destroySelected');
    Route::post($route.'/topic/sorting', [COPA04TopicItemController::class, 'sorting'])->name('admin.'.$routeName.'.topic.sorting');
    
    Route::resource($route.'/topicCaroussel', COPA04TopiccarouselController::class)->names('admin.'.$routeName.'.topicCaroussel')->parameters(['topicCaroussel' => 'COPA04ContentPagesTopiccarousel']);
    Route::post($route.'/topicCaroussel/delete', [COPA04TopiccarouselController::class, 'destroySelected'])->name('admin.'.$routeName.'.topicCaroussel.destroySelected');
    Route::post($route.'/topicCaroussel/sorting', [COPA04TopiccarouselController::class, 'sorting'])->name('admin.'.$routeName.'.topicCaroussel.sorting');
    
    Route::resource($route.'/topicCarousselCards', COPA04Topiccarousel_cardsController::class)->names('admin.'.$routeName.'.topicCarousselCards')->parameters(['topicCarousselCards' => 'TopiccarouselCards']);
    Route::post($route.'/topicCarousselCards/delete', [COPA04Topiccarousel_cardsController::class, 'destroySelected'])->name('admin.'.$routeName.'.topicCarousselCards.destroySelected');
    Route::post($route.'/topicCarousselCards/sorting', [COPA04Topiccarousel_cardsController::class, 'sorting'])->name('admin.'.$routeName.'.topicCarousselCards.sorting');

});
// // CLIENT
// Route::get($route.'/teste', [COPA04Controller::class, 'page'])->name($routeName.'.page');
