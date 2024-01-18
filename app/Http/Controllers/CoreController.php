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

    public function getRelations($module, $code, $config, $return='registers')
    {
        switch ($return) {
            case 'registers':
                $relationship = '';
                $listDropdown = [];
                $sublistDropdown = [];
                $modelDBSubrelation = '';
                $route = Str::lower($code).'.show';

                // Check for dropdown
                $include = isset($config->IncludeCore->include)?$config->IncludeCore->include:false;

                if(isset($config->IncludeCore)){
                    $moduleRaw = $module;
                    $module = clearVersionNameModule($module);
                    $modelElloquent = $this->Class->$module->$code->model;
                    $modelDB = self::getModelParameters($modelElloquent);

                    // BEGIN QUERY
                    $relations = $modelElloquent::query();
                    $existsRelation = false;
                    if($config->IncludeCore->relation){
                        $existsRelation = true;
                        $relationship = $config->IncludeCore->relation;
                        $arrRelations = get_object_vars($relationship);
                        foreach($config->IncludeCore->relation as $relationName => $configRealtion){
                            $modelDB = self::getModelParameters($this->Class->$module->$code->relationship[$relationName]['class']);
                            $route = Str::lower($code).'.'.$relationName.'.page';
                            $relations = $this->Class->$module->$code->relationship[$relationName]['class']::query();
                            break;
                        }
                    }

                    if($config->IncludeCore->limit <> 'all' && $config->IncludeCore->limit >= 1){
                        $relations = $relations->limit($config->IncludeCore->limit);
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
                            if(count($arrRelations)>1){
                                foreach ($relation->getRelationCore as $relationCore) {
                                    $key=0;
                                    foreach($config->IncludeCore->relation as $relationName => $configRealtion){
                                        if($key==1) {
                                            $modelDBSubrelation = self::getModelParameters($this->Class->$module->$code->relationship[$relationName]['class']);
                                            $subRoute = Str::lower($code).'.'.$relationName.'.page';
                                        }
                                        $key++;
                                    }

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

                        $titleReference = $this->InsertModelsMain->$moduleRaw->$code->IncludeCore->titleList;

                        $menu = (object) [
                            "id" => $relation->id,
                            "name" => $relation->$titleReference,
                            "slug" => $relation->slug,
                            "route" => $buildRouteParameters[$modelDB]?route($route, $buildRouteParameters):route($route),
                            'subList' => $sublistDropdown
                        ];

                        array_push($listDropdown, $menu);
                    }
                    return $listDropdown;
                }
            break;
            case 'relations':
                if(isset($config->IncludeCore)){
                    return $config->IncludeCore->relation;
                }
                return;
            break;
        }
    }

    public function buildListMenu()
    {
        $settingHeader = SettingHeader::sorting()->active()->get();
        $listMenu = [];
        foreach($settingHeader as $page){
            $listDropdown = [];
            $module = $page->module;
            $code = $page->model;
            $dropdown = null;
            if(!$page->link){
                $config = $this->InsertModelsMain->$module->$code; // Get config current model
            }

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

                        if(isset($this->Class->$module->$code->relationship)){
                            $paramsThis = [];
                            foreach ($this->Class->$module->$code->relationship as $relation => $value) {
                                $columnIdRef = $value['column'];
                                $routeName = $this->Class->$module->$code->routeName;
                                $queryRelation = $value['class']::find($item->$columnIdRef);

                                $getParam = self::getModelParameters($value['class']);

                                $paramsThis = array_merge($paramsThis, [$getParam => $queryRelation->slug]);
                            }

                            $paramsThis = array_merge($paramsThis, [$param => $item->slug]);
                            $routeCurrent = route($routeName, $paramsThis);

                        }else{
                            $routeCurrent = route($route, [$param => $item->slug]);
                        }

                        $menu = [
                            "id" => $item->id,
                            "name" => $item->$columTitleRef,
                            "slug" => $item->slug,
                            "route" => $routeCurrent,
                            'subList' => null
                        ];
                        array_push($listDropdown, $menu);
                    }
                }else{
                    $relation = explode(',', $dropdown); // Get relations to query
                    $r0=$relation[0]; // Get first telationship
                    $model = $this->Class->$module->$code->relationship[$r0]['class']; // Get model class
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
                            $modelSub = $this->Class->$module->$code->relationship[$r1]['class']; // Get model class
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

            if($page->page){
                $pageCurrent = $page->page;
                $menu = (object) [
                    "title" => $page->title,
                    "slug" => Str::slug($config->pages->$pageCurrent->name),
                    "anchor" => false,
                    "link" => $config->pages->$pageCurrent->route,
                    "dropdown" => $listDropdown,
                    "target_link" => $page->target_link,
                ];
            }

            if($page->link){
                $menu = (object) [
                    "title" => $page->title,
                    "slug" => Str::slug($page->title),
                    "anchor" => true,
                    "link" => $page->link,
                    "target_link" => $page->target_link,
                    "dropdown" => $listDropdown,
                    "target_link" => $page->target_link,
                ];
            }

            if(!$page->page && !$page->link){
                $menu = (object) [
                    "title" => $page->title,
                    "slug" => Str::slug($config->config->titleMenu),
                    "anchor" => $config->config->anchor,
                    "link" => $config->config->linkMenu,
                    "dropdown" => $listDropdown,
                    "target_link" => $page->target_link,
                ];
            }


            array_push($listMenu, $menu);
        }
        $response = json_encode($listMenu);
        return json_decode($response);
    }

    public function renderHeader()
    {
        $listMenu = self::buildListMenu();
        // dd(array_slice($listMenu, 0, 4), array_slice($listMenu, 4, 4));
        if(isset($this->InsertModelsCore->Headers->Code)){
            return view('Client.Core.Headers.'.$this->InsertModelsCore->Headers->Code.'.app', [
                'class' => $this->Class,
                'listMenu' => $listMenu
            ]);
        }
        return;
    }

    public function listModelFooter()
    {
        $listMenuFooter = [];
        foreach ($this->InsertModelsMain as $module => $models) {
            foreach ($models as $code => $config) {
                if($config->ViewListFooter){

                    $module = getNameModule($this->InsertModelsMain, $module, $code);

                    $listDropdown = self::getRelations($module, $code, $config);

                    $menu = [
                        "title" => $config->config->titleMenu,
                        "slug" => Str::slug($config->config->titleMenu),
                        "anchor" => $config->config->anchor,
                        "link" => $config->config->linkMenu,
                        "dropdown" => $listDropdown,
                    ];

                    array_push($listMenuFooter, $menu);
                }
            }
        }

        $response = json_encode($listMenuFooter);
        return json_decode($response);
    }

    public function renderFooter()
    {
        $listMenu = self::buildListMenu();
        $listModelFooter = self::listModelFooter();
        if(isset($this->InsertModelsCore->Footers->Code)){
            return view('Client.Core.Footers.'.$this->InsertModelsCore->Footers->Code.'.app', [
                'class' => $this->Class,
                'listMenu' => $listMenu,
                'listModelFooter' => $listModelFooter
            ]);
        }
        return;
    }
}
