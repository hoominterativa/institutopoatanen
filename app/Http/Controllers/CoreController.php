<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoreController extends Controller
{
    public static function renderHeader()
    {

        $InsertModelsCore = config('modelsConfig.InsertModelsCore');
        $Models = config('modelsConfig.Models');
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');

        $Categories = [];
        $menu = array();

        foreach($InsertModelsMain as $ListMenu){
            if(count(get_object_vars($ListMenu->ListMenu))){
                $Title = $ListMenu->ListMenu->Title?:'';
                $Anchor = $ListMenu->ListMenu->Anchor?:'';
                array_push($menu, (object) ['Title' => $Title, 'Anchor' => $Anchor]);
            }
        }

        if(count(get_object_vars($InsertModelsCore->Headers->IncludeCategory))){

            $ModelCategory = $InsertModelsCore->Headers->IncludeCategory->Model;
            $LimitCategory = $InsertModelsCore->Headers->IncludeCategory->Limit;
            $ModelClass = $Models->$ModelCategory->Model;

            $Categories = $ModelClass::limit($LimitCategory)->get();

            if(count(get_object_vars($InsertModelsCore->Headers->IncludeSubcategory))){
                $ModelSubcategory = $InsertModelsCore->Headers->IncludeSubcategory->Model;
                $Categories = $ModelClass::with('getHeader'.$ModelSubcategory)->limit($LimitCategory)->get();
            }
        }

        return view('Client.Core.Headers.'.$InsertModelsCore->Headers->Code.'.app', [
            'categoryHeader' => $Categories,
            'listMenu' => $menu
        ]);
    }

    public static function renderFooter()
    {
        // return view('Client.Core.Footers.FT001');
    }
}
