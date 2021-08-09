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

        // $a = collect($InsertModelsCore->Headers->IncludeCategory);

        // dd($a->count());

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
            'listMenu' => $InsertModelsMain
        ]);
    }

    public static function renderFooter()
    {
        $InsertModelsCore = config('modelsConfig.InsertModelsCore');
        $Models = config('modelsConfig.Models');
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');

        $Categories = [];

        if(count(get_object_vars($InsertModelsCore->Footers->IncludeCategory))){

            $ModelCategory = $InsertModelsCore->Footers->IncludeCategory->Model;
            $LimitCategory = $InsertModelsCore->Footers->IncludeCategory->Limit;
            $ModelClass = $Models->$ModelCategory->Model;

            $Categories = $ModelClass::limit($LimitCategory)->get();

            if(count(get_object_vars($InsertModelsCore->Footers->IncludeSubcategory))){
                $ModelSubcategory = $InsertModelsCore->Footers->IncludeSubcategory->Model;
                $Categories = $ModelClass::with('getHeader'.$ModelSubcategory)->limit($LimitCategory)->get();
            }
        }

        return view('Client.Core.Footers.'.$InsertModelsCore->Footers->Code.'.app', [
            'categoryFooter' => $Categories,
            'listMenu' => $InsertModelsMain
        ]);
        // return view('Client.Core.Footers.FT001');
    }
}
