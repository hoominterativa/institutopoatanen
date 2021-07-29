<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class IncludeSectionsController extends Controller
{
    public static function IncludeSectionsPage($GetModel)
    {
        $InsertSectionsPage = config('modelsConfig.InsertModelsMain');
        $IncludeSections = $InsertSectionsPage->$GetModel->IncludeSections;
        $return = [];

        if($IncludeSections){
            $ModelsController = config('modelsConfig.Models');

            foreach($IncludeSections as $model => $code){
                $Controller = $ModelsController->$model->$code->class;
                array_push($return, $Controller::section());
            }
        }

        return $return;
    }

    public static function IncludeSectionsHome()
    {
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');
        $ModelsController = config('modelsConfig.Models');
        $return = [];

        foreach($InsertModelsMain as $model => $view){
            $codeModel = $view->Code;
            $Controller = $ModelsController->$model->$codeModel->Class;
            if($view->ViewHome){
                array_push($return, $Controller::section());
            }
        }

        return $return;
    }
}
