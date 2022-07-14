<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    protected $InsertModelsCore;
    protected $Class;
    protected $InsertModelsMain;

    public function __construct()
    {
        $this->InsertModelsCore = config('modelsConfig.InsertModelsCore');
        $this->Class = config('modelsConfig.Class');
        $this->InsertModelsMain = config('modelsConfig.InsertModelsMain');
    }

    public function getRelations($module, $code, $config)
    {
        $relationship = '';
        $listDropdown = [];
        $sublistDropdown = [];
        $modelDBSubrelation = '';
        $route = Str::lower($code).'.show';

        $include = isset($config->IncludeCore->include)?$config->IncludeCore->include:false;

        if($include){

            $modelElloquent = $this->Class->$module->$code->model;
            $arrayModelElloquent = explode('\\', $modelElloquent);
            $modelDB = end($arrayModelElloquent);

            $relations = $modelElloquent::limit(9999);

            if($config->IncludeCore->limit <> 'all' && $config->IncludeCore->limit >= 1){
                $relations = $relations->limit($config->IncludeCore->limit);
            }

            if($config->IncludeCore->condition <> '' && $config->IncludeCore->condition <> null){
                $relations = $relations->where($config->IncludeCore->condition, 1);
            }

            if($config->IncludeCore->relation <> null && $config->IncludeCore->relation <> ''){

                $relationship = explode(',', $config->IncludeCore->relation);

                $modelElloquentRelation = $this->Class->$module->$code->relationship[$relationship[0]];
                $arrayModelElloquentRelation = explode('\\', $modelElloquentRelation);
                $modelDB = end($arrayModelElloquentRelation);

                $route = Str::lower($code).'.'.$relationship[0].'.page';

                $relations = $this->Class->$module->$code->relationship[$relationship[0]]::existsService()->limit(9999);

                if(count($relationship) > 1){
                    $modelElloquentSubrelation = $this->Class->$module->$code->relationship[$relationship[1]];
                    $arrayModelElloquentSubrelation = explode('\\', $modelElloquentSubrelation);
                    $modelDBSubrelation = end($arrayModelElloquentSubrelation);

                    $relations = $this->Class->$module->$code->relationship[$relationship[0]]::with('getRelationCore')->existsService()->limit(9999);
                }
            }

            if($config->IncludeCore->limit <> 'all' && $config->IncludeCore->limit >= 1){
                $relations = $relations->limit($config->IncludeCore->limit);
            }

            if($config->IncludeCore->condition <> '' && $config->IncludeCore->condition <> null){
                $relations = $relations->where($config->IncludeCore->condition, 1);
            }

            foreach ($relations->sorting()->get() as $relation) {
                $sublistDropdown = [];
                if(isset($relation->getRelationCore)){
                    foreach ($relation->getRelationCore as $relationCore) {
                        $subRoute = Str::lower($code).'.'.$relationship[1].'.page';

                        $subMenu = (object) [
                            "id" => $relationCore->id,
                            "name" => $relationCore->name,
                            "slug" => $relationCore->slug,
                            "route" => $subRoute,
                            "model" => [$modelDB => $relation->slug, $modelDBSubrelation => $relationCore->slug],
                        ];

                        array_push($sublistDropdown, $subMenu);
                    }
                }

                $menu = (object) [
                    "id" => $relation->id,
                    "name" => $relation->name,
                    "slug" => $relation->slug,
                    "route" => $route,
                    "model" => [$modelDB => $relation->slug],
                    'subList' => $sublistDropdown
                ];



                array_push($listDropdown, $menu);
            }

            return $listDropdown;
        }
    }


    public function renderHeader()
    {
        $listMenu = [];

        foreach ($this->InsertModelsMain as $module => $model) {
            foreach ($model as $code => $config) {
                if($config->ViewListMenu){
                    $dropdown = self::getRelations($module, $code, $config);

                    $menu = (object) [
                        "title" => $config->config->titleMenu,
                        "anchor" => $config->config->anchor,
                        "link" => $config->config->linkMenu,
                        "dropdown" => $dropdown,
                    ];

                    array_push($listMenu, $menu);
                }
            }
        }

        if(isset($this->InsertModelsCore->Headers->Code)){
            return view('Client.Core.Headers.'.$this->InsertModelsCore->Headers->Code.'.app', [
                'class' => $this->Class,
                'listMenu' => $listMenu
            ]);
        }
        return;
    }

    public function renderFooter()
    {
        if(isset($this->InsertModelsCore->Footers->Code)){
            return view('Client.Core.Footers.'.$this->InsertModelsCore->Footers->Code.'.app', [
                'class' => $this->Class,
                'listMenu' => $this->InsertModelsMain
            ]);
        }
        return;
    }
}
