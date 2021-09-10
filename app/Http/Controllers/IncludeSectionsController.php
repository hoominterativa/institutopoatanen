<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class IncludeSectionsController extends Controller
{
    public static function IncludeSectionsPage($GetModule, $getModel)
    {
        $InsertSectionsPage = config('modelsConfig.InsertModelsMain');
        $IncludeSections = $InsertSectionsPage->$GetModule->$getModel->IncludeSections;
        $return = [];

        if($IncludeSections){
            $ModelsController = config('modelsConfig.Class');

            foreach($IncludeSections as $model => $code){
                $Controller = $ModelsController->$model->$code->controller;
                array_push($return, $Controller::section());
            }
        }

        return $return;
    }

    public static function IncludeSectionsHome()
    {
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');
        $ModelsController = config('modelsConfig.Class');
        $return = [];

        foreach($InsertModelsMain as $module => $model){
            foreach ($model as $code => $config) {
                if($config->ViewHome){
                    $Controller = $ModelsController->$module->$code->controller;
                    array_push($return, $Controller::section());
                }
            }
        }

        return $return;
    }
}
