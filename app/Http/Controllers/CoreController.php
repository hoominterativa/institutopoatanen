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

            // dd($relations->sorting()->get());

            foreach ($relations->sorting()->get() as $relation) {
                $sublistDropdown = [];
                $buildRouteParameters = [$modelDB => $relation->slug];
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

                if(!$existsRelation){
                    $buildRouteParameters = [];
                    $queryRelationship = $this->Class->$module->$code->relationship;

                    foreach ($queryRelationship as $relationship) {
                        $column = $relationship['column'];
                        $slugRelationShip = $relationship['class']::where('id', $relation->$column)->first();
                        $routeParameters = self::getModelParameters($relationship['class']);
                        $buildRouteParameters = array_merge($buildRouteParameters, [$routeParameters => $slugRelationShip->slug]);
                    }
                    $buildRouteParameters = array_merge($buildRouteParameters, [$modelDB => $relation->slug]);
                }

                $menu = (object) [
                    "id" => $relation->id,
                    "name" => $relation->name??$relation->title,
                    "slug" => $relation->slug,
                    "route" => route($route, $buildRouteParameters),
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

        foreach ($this->InsertModelsMain as $module => $model) {
            foreach ($model as $code => $config) {
                if($config->ViewListMenu){
                    $dropdown = self::getRelations($module, $code, $config);

                    $menu = (object) [
                        "title" => $config->config->titleMenu,
                        "slug" => Str::slug($config->config->titleMenu),
                        "anchor" => $config->config->anchor,
                        "link" => $config->config->linkMenu,
                        "dropdown" => $dropdown,
                    ];

                    array_push($listMenu, $menu);
                }
            }
        }

        return $listMenu;
    }


    public function renderHeader()
    {
        $listMenu = self::relationsHeaderMenu();

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
        $listMenu = self::relationsHeaderMenu();

        if(isset($this->InsertModelsCore->Footers->Code)){
            return view('Client.Core.Footers.'.$this->InsertModelsCore->Footers->Code.'.app', [
                'class' => $this->Class,
                'listMenu' => $listMenu
            ]);
        }
        return;
    }
}
