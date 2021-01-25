<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoreController extends Controller
{
    public static function header()
    {

        $InsertModelsCore = config('modelsConfig.InsertModelsCore');
        $Models = config('modelsConfig.Models');
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');

        $Categories = '';
        $Subcategories = '';
        $menu = array();

        foreach($InsertModelsMain as $ListMenu){
            $Title = $ListMenu->ListMenu->Title?:'';
            $Anchor = $ListMenu->ListMenu->Anchor?:'';
            array_push($menu, (object) ['Title' => $Title, 'Anchor' => $Anchor]);
        }

        if(count(get_object_vars($InsertModelsCore->Header->IncludeCategory))){

            $ModelCategory = $InsertModelsCore->Header->IncludeCategory->Model;
            $CodeCategory = $InsertModelsCore->Header->IncludeCategory->Code;
            $LimitCategory = $InsertModelsCore->Header->IncludeCategory->Limit;
            $ModelClass = $Models->$ModelCategory->$CodeCategory;

            $ClassModelCategory = $ModelClass->Category;
            // $Categories = $ClassModelCategory::limit($LimitCategory)->get();
            $Categories = $ClassModelCategory;

        }

        if(count(get_object_vars($InsertModelsCore->Header->IncludeSubcategory))){

            $ModelSubcategory = $InsertModelsCore->Header->IncludeSubcategory->Model;
            $CodeSubcategory = $InsertModelsCore->Header->IncludeSubcategory->Code;
            $LimitSubcategory = $InsertModelsCore->Header->IncludeSubcategory->Limit;
            $ModelClass = $Models->$ModelSubcategory->$CodeSubcategory;

            $ClassModelSubcategory = $ModelClass->Subcategory;
            // $Subcategories = $ClassModelSubcategory::limit($LimitSubcategory)->get();
            $Subcategories = $ClassModelSubcategory;

        }


        // dd($menu);

        return view('Client.core.headers.'.$InsertModelsCore->Header->Code, [
            'categoryHeader' => $Categories,
            'subcategoryHeader' => $Subcategories,
            'listMenu' => $menu
        ]);
    }

    public static function footer()
    {
        return view('core.footers.FT001');
    }
}
