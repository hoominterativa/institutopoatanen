<?php

namespace App\Http\Controllers;

use App\Models\SettingHeader;
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
                "select_dropdown" => null,
                "condition" => null,
                "exists" => false,
                "limit" => null,
            ],
            [
                "title" => "Soluções",
                "module" => "Services",
                "model" => "SERV01",
                "dropdown" => true,
                "select_dropdown" => 'this',
                "condition" => 0,
                "exists" => false,
                "limit" => null,
            ],
            [
                "title" => "Artigos",
                "module" => "Blogs",
                "model" => "BLOG01",
                "dropdown" => true,
                "select_dropdown" => 'this',
                "condition" => 0,
                "exists" => true,
                "limit" => null,
            ],
            [
                "title" => "Portifólio",
                "module" => "Portfolios",
                "model" => "PORT01",
                "dropdown" => true,
                "select_dropdown" => 'category,subcategory',
                "condition" => 0,
                "exists" => true,
                "limit" => null,
            ],

        ];

        $arrayPages = json_encode($arrayPages);

        $settingHeader = SettingHeader::sorting()->active()->get();
        $listMenu = [];
        foreach($settingHeader as $page){
            $listDropdown = [];
            $module = $page->module;
            $code = $page->model;
            $dropdown = null;
            $config = $this->InsertModelsMain->$module->$code; // Get config current model

            if($page->dropdown){
                $dropdown = $page->select_dropdown;
                /*
                If the $dropdown variable is "this", a direct query will be performed on the main table
                If not, a query will be made on the relationship table
                The query return will be in the $query variable
                */
                if($dropdown==='this'){
                    $model = $this->Class->$module->$code->model; // Get model class
                    $query = $model::query(); // begin query

                    // conditions
                    if($page->condition<>null){
                        $condition = explode(',', $config->IncludeCore->condition);
                        $splitCondition = explode('{', $condition[$page->condition]);
                        $query = $query->whereRaw($splitCondition[0]);
                    }
                    if($page->limit<>null) $query = $query->limit($page->limit);

                    // get query
                    $query = $query->get();

                    // Build array for dropdown
                    foreach($query as $item){
                        $param = self::getModelParameters($model); // Get parameter the model
                        $route = Str::lower($code).'.show'; // Build route
                        $columTitleRef = $config->IncludeCore->titleList; // Get reference title

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
                    $relation = explode(',', $dropdown); // Get relations to query
                    $r0=$relation[0]; // Get first telationship
                    $model = $this->Class->$module->$code->relationship->$r0->class; // Get model class
                    $param = self::getModelParameters($model); // Get parameter the model
                    $subRoute = Str::lower($code).'.'.$r0.'.page'; // Build route

                    $query = $model::query();// begin query

                    // If the dropdown has more than one level
                    if(count($relation) > 1){
                        $query = $query->with('getRelationCore');
                    }

                    // conditions
                    if($page->exists) $query = $query->existsRegister();
                    if($page->condition!==null){
                        $condition = explode(',', $config->IncludeCore->relation->$r0->condition);
                        $splitCondition = explode('{', $condition[$page->condition]);
                        $query = $query->whereRaw($splitCondition[0]);
                    }
                    if($page->limit<>null) $query = $query->limit($page->limit);

                    // get query
                    $query = $query->get();

                    // Build array for dropdown
                    foreach($query as $item){
                        $columTitleRef = $config->IncludeCore->relation->$r0->titleList; // Get reference title
                        $dropdownSub = [];

                        if(count($relation) > 1){
                            $r1=$relation[1];
                            $columTitleRefSub = $config->IncludeCore->relation->$r1->titleList; // Get reference title
                            $modelSub = $this->Class->$module->$code->relationship->$r1->class; // Get model class
                            $paramSub = self::getModelParameters($modelSub); // Get parameter the model

                            // Build array for subitems
                            foreach($item->getRelationCore as $subItem){
                                $subMenu = [
                                    "id" => $subItem->id,
                                    "name" => $subItem->$columTitleRefSub,
                                    "slug" => Str::slug($subItem->$columTitleRefSub),
                                    "route" => route($subRoute, [$param => Str::slug($item->$columTitleRef), $paramSub => Str::slug($subItem->$columTitleRefSub)]),
                                ];
                                array_push($dropdownSub, $subMenu);
                            }

                        }

                        $menu = [
                            "id" => $item->id,
                            "name" => $item->$columTitleRef,
                            "slug" => Str::slug($item->$columTitleRef),
                            "route" => route($subRoute, [$param => Str::slug($item->$columTitleRef)]),
                            'subList' => count($dropdownSub)?$dropdownSub:null
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
