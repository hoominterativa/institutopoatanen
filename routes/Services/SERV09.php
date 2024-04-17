<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Services\SERV09Controller;
use App\Http\Controllers\Services\SERV09CityController;
use App\Http\Controllers\Services\SERV09StateController;
use App\Http\Controllers\Services\SERV09TopicController;
use App\Http\Controllers\Services\SERV09ContentController;
use App\Http\Controllers\Services\SERV09GalleryController;
use App\Http\Controllers\Services\SERV09SectionController;
use App\Http\Controllers\Services\SERV09CategoryController;
use App\Http\Controllers\Services\SERV09FeedbackController;
use App\Http\Controllers\Services\SERV09TopicsUpController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Services';
$model = 'SERV09';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName) {
    //Categories
    Route::resource($route . '/categorias', SERV09CategoryController::class)->names('admin.' . $routeName . '.category')->parameters(['categorias' => 'SERV09ServicesCategory']);
    Route::post($route . '/categoria/delete', [SERV09CategoryController::class, 'destroySelected'])->name('admin.' . $routeName . '.category.destroySelected');
    Route::post($route . '/categoria/sorting', [SERV09CategoryController::class, 'sorting'])->name('admin.' . $routeName . '.category.sorting');

    //States
    Route::resource($route . '/estados', SERV09StateController::class)->names('admin.' . $routeName . '.state')->parameters(['estados' => 'SERV09ServicesState']);
    Route::post($route . '/estado/delete', [SERV09StateController::class, 'destroySelected'])->name('admin.' . $routeName . '.state.destroySelected');
    Route::post($route . '/estado/sorting', [SERV09StateController::class, 'sorting'])->name('admin.' . $routeName . '.state.sorting');

    //Cities
    Route::resource($route . '/cidades', SERV09CityController::class)->names('admin.' . $routeName . '.city')->parameters(['cidades' => 'SERV09ServicesCity']);
    Route::post($route . '/cidade/delete', [SERV09CityController::class, 'destroySelected'])->name('admin.' . $routeName . '.city.destroySelected');
    Route::post($route . '/cidade/sorting', [SERV09CityController::class, 'sorting'])->name('admin.' . $routeName . '.city.sorting');

    //Topics
    Route::resource($route . '/topicos', SERV09TopicController::class)->names('admin.' . $routeName . '.topic')->parameters(['topicos' => 'SERV09ServicesTopic']);
    Route::post($route . '/topico/delete', [SERV09TopicController::class, 'destroySelected'])->name('admin.' . $routeName . '.topic.destroySelected');
    Route::post($route . '/topico/sorting', [SERV09TopicController::class, 'sorting'])->name('admin.' . $routeName . '.topic.sorting');

    //TopicsUp
    Route::resource($route . '/topicosup', SERV09TopicsUpController::class)->names('admin.' . $routeName . '.topicup')->parameters(['topicosup' => 'SERV09ServicesTopicsUp']);
    Route::post($route . '/topicoup/delete', [SERV09TopicsUpController::class, 'destroySelected'])->name('admin.' . $routeName . '.topicup.destroySelected');
    Route::post($route . '/topicoup/sorting', [SERV09TopicsUpController::class, 'sorting'])->name('admin.' . $routeName . '.topicup.sorting');

    //Gallery
    Route::resource($route . '/galeria', SERV09GalleryController::class)->names('admin.' . $routeName . '.gallery')->parameters(['galeria' => 'SERV09ServicesGallery']);
    Route::post($route . '/galeria/delete', [SERV09GalleryController::class, 'destroySelected'])->name('admin.' . $routeName . '.gallery.destroySelected');
    Route::post($route . '/galeria/sorting', [SERV09GalleryController::class, 'sorting'])->name('admin.' . $routeName . '.gallery.sorting');

    //Content
    Route::resource($route . '/conteudos', SERV09ContentController::class)->names('admin.' . $routeName . '.content')->parameters(['conteudos' => 'SERV09ServicesContent']);
    Route::post($route . '/conteudo/delete', [SERV09ContentController::class, 'destroySelected'])->name('admin.' . $routeName . '.content.destroySelected');
    Route::post($route . '/conteudo/sorting', [SERV09ContentController::class, 'sorting'])->name('admin.' . $routeName . '.content.sorting');

    //Feedback
    Route::resource($route . '/feedbacks', SERV09FeedbackController::class)->names('admin.' . $routeName . '.feedback')->parameters(['feedbacks' => 'SERV09ServicesFeedback']);
    Route::post($route . '/feedback/delete', [SERV09FeedbackController::class, 'destroySelected'])->name('admin.' . $routeName . '.feedback.destroySelected');
    Route::post($route . '/feedback/sorting', [SERV09FeedbackController::class, 'sorting'])->name('admin.' . $routeName . '.feedback.sorting');

    //Sections: Home && Banner page
    Route::resource($route . '/secao', SERV09SectionController::class)->names('admin.' . $routeName . '.section')->parameters(['secao' => 'SERV09ServicesSection']);
});
// CLIENT
Route::get($route . '/categoria/{SERV09ServicesCategory:slug}', [SERV09Controller::class, 'page'])->name($routeName . '.category.page');
Route::get('categoria/{SERV09ServicesCategory:slug}/' . $route . '/{SERV09Services:slug}', [SERV09Controller::class, 'show'])->name($routeName . '.page.content');

Route::post('processa-cidade/' . $route, [SERV09Controller::class, 'search'])->name($routeName . '.processa-cidade'); // NOTE:  NAME: serv09.processa-cidade
