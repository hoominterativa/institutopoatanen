<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;


class IncludeSectionsController extends Controller
{
    public function IncludeSectionsPage($GetModule, $getModel, $where=null)
    {
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');
        $configModel = $InsertModelsMain->$GetModule->$getModel;
        $IncludeSections = $configModel->IncludeSections??null;
        $contactForm = new ContactFormController();
        $page = Str::slug($configModel->config->titleMenu);

        $return = [];
        $vf = 0;

        if($IncludeSections){
            foreach($IncludeSections as $model => $config){
                $code = $config;
                $ModelsController = config('modelsClass.Class');
                if(is_array($config)){
                    $code = $config[0];
                    $form = $contactForm->sectionPage($page, $code);

                    if(count($config)>1){
                        if($where == $config[1]){
                            $Controller = $ModelsController->$model->$code->controller;

                            if(COUNT($form)){
                                switch ($form['position']) {
                                    case 'after':
                                        $view = $Controller::section()->render();
                                        $view .= $form['view'];
                                    break;
                                    case 'before':
                                        $view = $form['view'];
                                        $view .= $Controller::section()->render();
                                    break;
                                }
                                $vf++;
                            }else{
                                $view = $Controller::section()->render();
                            }

                            array_push($return, $view);
                        }
                    }else{
                        $Controller = $ModelsController->$model->$code->controller;
                        if(COUNT($form)){
                            switch ($form['position']) {
                                case 'after':
                                    $view = $Controller::section()->render();
                                    $view .= $form['view'];
                                break;
                                case 'before':
                                    $view = $form['view'];
                                    $view .= $Controller::section()->render();
                                break;
                            }
                            $vf++;
                        }else{
                            $view = $Controller::section()->render();
                        }

                        array_push($return, $view);
                    }
                }else{
                    $form = $contactForm->sectionPage($page, $code);

                    $Controller = $ModelsController->$model->$code->controller;
                    if(COUNT($form)){
                        switch ($form['position']) {
                            case 'after':
                                $view = $Controller::section()->render();
                                $view .= $form['view'];
                            break;
                            case 'before':
                                $view = $form['view'];
                                $view .= $Controller::section()->render();
                            break;
                        }
                        $vf++;
                    }else{
                        $view = $Controller::section()->render();
                    }

                    array_push($return, $view);
                }
            }
        }

        if(!$vf){
            $form = $contactForm->sectionPage($page);
            if(COUNT($form)){
                array_push($return, $form['view']);
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
