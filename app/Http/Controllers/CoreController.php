<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CoreController extends Controller
{
    protected $InsertModelsCore;
    protected $Class;
    protected $InsertModelsMain;

    public function __construct()
    {
        $this->InsertModelsCore = config('modelsConfig.InsertModelsCore');
        $this->Class = config('modelsClass.Class');
        $this->InsertModelsMain = config('modelsConfig.InsertModelsMain');
    }

    public function getModelParameters($class)
    {
        $arrayModelElloquent = explode('\\', $class);
        return end($arrayModelElloquent);
    }

    public function getRelations($module, $code, $config)
    {
        $relationship = '';
        $listDropdown = [];
        $sublistDropdown = [];
        $modelDBSubrelation = '';
        $route = Str::lower($code).'.show';

        // Check for dropdown
        $include = isset($config->IncludeCore->include)?$config->IncludeCore->include:false;

        if($include){
            $modelElloquent = $this->Class->$module->$code->model;
            $modelDB = self::getModelParameters($modelElloquent);

            // BEGIN QUERY
            $relations = $modelElloquent::limit(9999);

            $existsRelation = false;
            if($config->IncludeCore->relation <> null && $config->IncludeCore->relation <> ''){
                $existsRelation = true;
                $relationship = explode(',', $config->IncludeCore->relation);

                $modelDB = self::getModelParameters($this->Class->$module->$code->relationship[$relationship[0]]['class']);

                $route = Str::lower($code).'.'.$relationship[0].'.page';

                $relations = $this->Class->$module->$code->relationship[$relationship[0]]['class']::existsRegister()->limit(9999);

                if(count($relationship) > 1){
                    $modelDBSubrelation = self::getModelParameters($this->Class->$module->$code->relationship[$relationship[1]]['class']);
                    $relations = $this->Class->$module->$code->relationship[$relationship[0]]['class']::with('getRelationCore')->existsRegister()->limit(9999);
                }
            }

            if($config->IncludeCore->limit <> 'all' && $config->IncludeCore->limit >= 1){
                $relations = $relations->limit($config->IncludeCore->limit);
            }

            if($config->IncludeCore->condition <> '' && $config->IncludeCore->condition <> null){
                $relations = $relations->whereRaw($config->IncludeCore->condition);
            }

            if($config->IncludeCore->sorting){
                $query = $relations->sorting()->get();
            }else{
                $query = $relations->get();
            }

            foreach ($query as $relation) {
                $sublistDropdown = [];
                $buildRouteParameters = [$modelDB => $relation->slug];
                if($existsRelation){
                    if(count($relationship) > 1){
                        foreach ($relation->getRelationCore as $relationCore) {
                            $subRoute = Str::lower($code).'.'.$relationship[1].'.page';

                            $subMenu = (object) [
                                "id" => $relationCore->id,
                                "name" => $relationCore->name??$relationCore->title,
                                "slug" => $relationCore->slug,
                                "route" => route($subRoute, [$modelDB => $relation->slug, $modelDBSubrelation => $relationCore->slug]),
                            ];

                            array_push($sublistDropdown, $subMenu);
                        }
                    }
                }

                $menu = (object) [
                    "id" => $relation->id,
                    "name" => ($relation->name??$relation->title)??$relation->title_page,
                    "slug" => $relation->slug,
                    "route" => $buildRouteParameters[$modelDB]?route($route, $buildRouteParameters):route($route),
                    'subList' => $sublistDropdown
                ];

                array_push($listDropdown, $menu);
            }

            return $listDropdown;
        }
    }

    public function relationsHeaderMenu()
    {
        $listMenu = [];

        // foreach ($this->InsertModelsMain as $module => $model) {
        //     foreach ($model as $code => $config) {
        //         if($config->ViewListMenu){
        //             $dropdown = self::getRelations($module, $code, $config);

        //             $menu = (object) [
        //                 "title" => $config->config->titleMenu,
        //                 "slug" => Str::slug($config->config->titleMenu),
        //                 "anchor" => $config->config->anchor,
        //                 "link" => $config->config->linkMenu,
        //                 "listFooter" => $config->ViewListFooter,
        //                 "viewer" => $config->Viewer,
        //                 "dropdown" => $dropdown,
        //             ];

        //             array_push($listMenu, $menu);
        //         }
        //     }
        // }

        return $listMenu;
    }


    public function renderHeader()
    {

        $arrayPages = [
            [
                "title" => "Sobre",
                "module" => "Abouts",
                "model" => "ABOU01",
                "dropdown" => false,
                "selectDropdown" => null,
                "condition" => null,
                "limit" => null,
            ],
            [
                "title" => "Soluções",
                "module" => "Services",
                "model" => "SERV01",
                "dropdown" => true,
                "selectDropdown" => 'this',
                "condition" => "0",
                "limit" => null,
            ],
            [
                "title" => "Artigos",
                "module" => "Blogs",
                "model" => "BLOG01",
                "dropdown" => true,
                "selectDropdown" => 'category',
                "condition" => "0",
                "limit" => null,
            ],

        ];
        $arrayPages = json_encode($arrayPages);

        $listMenu = [];
        foreach(json_decode($arrayPages) as $page){
            $listDropdown = [];
            $module = $page->module;
            $code = $page->model;
            $dropdown = null;
            $config = $this->InsertModelsMain->$module->$code;

            if($page->dropdown){
                $dropdown = $page->selectDropdown;
                /*
                Se for "this" será realizada uma consulta na tabela direta
                Se não será feita uma consulta na tabela do relacionamento
                O retorno da consulta estara na variaval $query
                */
                if($dropdown==='this'){
                    $model = $this->Class->$module->$code->model;
                    $query = $model::query();

                    if($page->condition<>null){
                        $condition = explode(',', $config->IncludeCore->condition);
                        $query = $model::whereRaw($condition[$page->condition]);
                    }
                    if($page->limit<>null) $query = $query->limit($page->limit);
                    $query = $query->get();

                    foreach($query as $item){
                        $param = self::getModelParameters($model);
                        $route = Str::lower($code).'.show';
                        $columTitleRef = $config->IncludeCore->titleList;

                        $menu = [
                            "id" => $item->id,
                            "name" => $item->$columTitleRef,
                            "slug" => Str::slug($item->$columTitleRef),
                            "route" => route($route, [$param => Str::slug($item->$columTitleRef)]),
                            'subList' => null
                        ];
                        array_push($listDropdown, $menu);
                    }
                }else{
                    $relation = explode(',', $dropdown);
                    $r0=$relation[0];
                    $model = $this->Class->$module->$code->relationship->$r0->class;
                    $param = self::getModelParameters($model);
                    $subRoute = Str::lower($code).'.'.$r0.'.page';
                    $query = $model::query();

                    if(count($relation) > 1){
                        $query = $model::with('getRelationCore');
                    }

                    if($page->condition<>null){
                        $condition = explode(',', $config->IncludeCore->relation->$r0->condition);
                        $query = $query->whereRaw($condition[$page->condition]);
                    }
                    if($page->limit<>null) $query = $query->limit($page->limit);
                    $query = $query->get();


                    foreach($query as $item){
                        $columTitleRef = $config->IncludeCore->relation->$r0->titleList;
                        if(count($relation) > 1){

                            $dropdowSub = [];
                            $r1=$relation[1];
                            $columTitleRefSub = $config->IncludeCore->relation->$r1->titleList;
                            $modelSub = $this->Class->$module->$code->relationship->$r1->class;
                            $paramSub = self::getModelParameters($modelSub);

                            foreach($item->getRelationCore as $subItem){
                                $subMenu = (object) [
                                    "id" => $subItem->id,
                                    "name" => $subItem->$columTitleRefSub,
                                    "slug" => Str::slug($subItem->$columTitleRefSub),
                                    "route" => route($subRoute, [$param => Str::slug($item->$columTitleRef), $paramSub => Str::slug($subItem->$columTitleRefSub)]),
                                ];
                                $dropdowSub = array_merge($dropdowSub, $subMenu);
                            }

                        }

                        $menu = [
                            "id" => $item->id,
                            "name" => $item->$columTitleRef,
                            "slug" => Str::slug($item->$columTitleRef),
                            "route" => route($subRoute, [$param => Str::slug($item->$columTitleRef)]),
                            'subList' => null
                        ];
                        array_push($listDropdown, $menu);
                    }
                }
            }

            $menu = (object) [
                "title" => $page->title,
                "slug" => Str::slug($config->config->titleMenu),
                "anchor" => $config->config->anchor,
                "link" => $config->config->linkMenu,
                "dropdown" => $listDropdown,
            ];

            array_push($listMenu, $menu);
        }

        $listMenu = json_encode($listMenu);

        if(isset($this->InsertModelsCore->Headers->Code)){
            return view('Client.Core.Headers.'.$this->InsertModelsCore->Headers->Code.'.app', [
                'class' => $this->Class,
                'listMenu' => json_decode($listMenu)
            ]);
        }
        return;
    }

    public function renderFooter()
    {
        // $listMenu = self::relationsHeaderMenu();
        // if(isset($this->InsertModelsCore->Footers->Code)){
        //     return view('Client.Core.Footers.'.$this->InsertModelsCore->Footers->Code.'.app', [
        //         'class' => $this->Class,
        //         'listMenu' => $listMenu
        //     ]);
        // }
        return;
    }
}
