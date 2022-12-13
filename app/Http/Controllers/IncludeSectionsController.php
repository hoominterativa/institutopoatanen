<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class IncludeSectionsController extends Controller
{
    public function IncludeSectionsPage($GetModule, $getModel)
    {
        $InsertSectionsPage = config('modelsConfig.InsertModelsMain');
        $IncludeSections = $InsertSectionsPage->$GetModule->$getModel->IncludeSections??null;

        $return = [];

        if($IncludeSections){
            foreach($IncludeSections as $model => $code){
                $ModelsController = config('modelsClass.Class');
                $Controller = $ModelsController->$model->$code->controller;
                array_push($return, $Controller::section());
            }
        }

        return $return;
    }

    public function IncludeSectionsHome()
    {
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');
        $return = [];

        foreach($InsertModelsMain as $module => $model){
            $ModelsController = config('modelsClass.Class');
            $moduleName = explode('.', $module)[0];
            foreach ($model as $code => $config) {
                if($config->ViewHome){
                    $Controller = $ModelsController->$moduleName->$code->controller;
                    $return = array_merge($return, [$code => $Controller::section()->render()]);
                }
            }
        }

        return $return;
    }
}
