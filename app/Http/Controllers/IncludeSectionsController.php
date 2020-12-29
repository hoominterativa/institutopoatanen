<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncludeSectionsController extends Controller
{
    public static function IncludeSectionsPage($GetModel)
    {
        $return = [];
        $InsertSectionsPage = config('modelsConfig.InsertModelsMain');
        $IncludeSections = $InsertSectionsPage->$GetModel->IncludeSections;
        if($IncludeSections){
            $ModelsController = config('modelsConfig.Models');

            foreach($IncludeSections as $model => $code){
                $ModelName = (preg_match('~s$~i', $model) > 0) ? rtrim($model, 's') : sprintf('%ss', $model);
                $Controller = $ModelsController->$ModelName->$code;
                $views = $Controller::section(strtolower($ModelName).'::'.$code.'.Client.section');
                array_push($return, $views);
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
            $ModelName = (preg_match('~s$~i', $model) > 0) ? rtrim($model, 's') : sprintf('%ss', $model);
            $codeModel = $view->Code;
            $Controller = $ModelsController->$ModelName->$codeModel;
            $views = $Controller::section(strtolower($ModelName).'::'.$view->Code.'.Client.section');
            if($view->ViewHome){
                array_push($return, $views);
            }
        }

        return $return;
    }
}
