<?php

/*
    Abaixo será necessário listar as rotas do lado do "CLIENT" manualmente
    Editar Somente os "NAMES" das Rotas substituindo "NAME" pelo módulo atual
    Editar tbm o prefixo para o nome do módulo atual
*/

Route::prefix('product')->group(function()
{
    $InsertModelsMain = config('modelsConfig.InsertModelsMain')->Slide;

    $codeModel = $InsertModelsMain->Code;
    $ControllerResource = $codeModel.'Controller';

    Route::get('/', $ControllerResource.'@list')->name('admin.NAME.list');

    if($InsertModelsMain->Category){
        Route::get('/{category}', $ControllerResource.'@category')->name('admin.NAME.category');
        Route::get('/{category}/{subcategory}', $ControllerResource.'@subcategory')->name('admin.NAME.subcategory');
        Route::get('/{category}/{subcategory}/{product}', $ControllerResource.'@show')->name('admin.NAME');
    }else{
        /* Manter esse else se caso haja uma página interna (Ex.: página interna de produto) */
        Route::get('/{product}', $ControllerResource.'@show')->name('admin.NAME');
    }

});

/*
Montagem das Rotas do lado do "ADMIN", não mexer!
*/

Route::prefix('painel')->group(function()
{

    $InsertModelsMain = config('modelsConfig.InsertModelsMain')->Slide;

    $codeModel = $InsertModelsMain->Code;
    $ControllerResource = $codeModel.'Controller';

    Route::resource('/slide', $ControllerResource)->names('admin.slides')->parameters(['slide' => 'slide']);

    if($InsertModelsMain->Category){
        $ControllerCategoryResource = $codeModel.'CategoryController';
        Route::resource('/slide/categoria', $ControllerCategoryResource)->names('admin.slides.category')->parameters(['categoria' => 'category']);
    }

});

