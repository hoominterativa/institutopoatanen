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

        if(count(get_object_vars($InsertModelsCore->Header->IncludeCategory))){

            $ModelCategory = $InsertModelsCore->Header->IncludeCategory->Model;
            $LimitCategory = $InsertModelsCore->Header->IncludeCategory->Limit;
            $ModelClass = $Models->$ModelCategory->Model;

            $Categories = $ModelClass::limit($LimitCategory)->get();

            if(count(get_object_vars($InsertModelsCore->Header->IncludeSubcategory))){
                $ModelSubcategory = $InsertModelsCore->Header->IncludeSubcategory->Model;
                $Categories = $ModelClass::with('getHeader'.$ModelSubcategory)->limit($LimitCategory)->get();
            }
        }

        return view('Client.Core.headers.'.$InsertModelsCore->Header->Code, [
            'categoryHeader' => $Categories,
            'listMenu' => $menu
        ]);
    }

    public static function renderFooter()
    {
        return view('Client.Core.footers.FT001');
    }
}
