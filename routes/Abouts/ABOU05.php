<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\Abouts\ABOU05AboutsSection;
use App\Http\Controllers\Abouts\ABOU05SocialController;
use App\Http\Controllers\Abouts\ABOU05ContentController;
use App\Http\Controllers\Abouts\ABOU05SectionController;

/**
 * Uncomment the code below
 *
 * Create new routes to admin or client according to the model below
 * Define the variables ​​$module, $model and import the controller class
 *
 */

$module = 'Abouts';
$model = 'ABOU05';

$class = config('modelsConfig.Class');
$modelConfig = config('modelsConfig.InsertModelsMain');
$module = getNameModule($modelConfig, $module, $model);
$modelConfig = $modelConfig->$module->$model->config;

$route = Str::slug($modelConfig->titlePanel);
$routeName = Str::lower($model);

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function () use (&$route, $routeName){
    //Content
    Route::resource($route.'/conteudos', ABOU05ContentController::class)->names('admin.'.$routeName.'.content')->parameters(['conteudos' => 'ABOU05AboutsContent']);
    Route::post($route.'/conteudo/delete', [ABOU05ContentController::class, 'destroySelected'])->name('admin.'.$routeName.'.content.destroySelected');
    Route::post($route.'/conteudo/sorting', [ABOU05ContentController::class, 'sorting'])->name('admin.'.$routeName.'.content.sorting');
    //Social
    Route::resource($route.'/socials', ABOU05SocialController::class)->names('admin.'.$routeName.'.social')->parameters(['socials' => 'ABOU05AboutsSocial']);
    Route::post($route.'/social/delete', [ABOU05SocialController::class, 'destroySelected'])->name('admin.'.$routeName.'.social.destroySelected');
    Route::post($route.'/social/sorting', [ABOU05SocialController::class, 'sorting'])->name('admin.'.$routeName.'.social.sorting');
    //Section
    Route::resource($route.'/secao', ABOU05SectionController::class)->names('admin.'.$routeName.'.section')->parameters(['secao' => 'ABOU05AboutsSection']);
    //Banner
    Route::resource($route.'/banner', ABOU05SectionController::class)->names('admin.'.$routeName.'.banner')->parameters(['banner' => 'ABOU05AboutsSection']);
    //Section Content
    Route::resource($route.'/secao-conteudo', ABOU05SectionController::class)->names('admin.'.$routeName.'.section_content')->parameters(['secao-conteudo' => 'ABOU05AboutsSection']);
});
