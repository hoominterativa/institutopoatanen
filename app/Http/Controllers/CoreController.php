<?php

namespace App\Http\Controllers;

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


    public function renderHeader()
    {

        if(count(get_object_vars($this->InsertModelsCore))){
            $Categories = [];

            if(count(get_object_vars($this->InsertModelsCore->Headers->IncludeCategory))){

                $ModelCategory = $this->InsertModelsCore->Headers->IncludeCategory->Model;
                $LimitCategory = $this->InsertModelsCore->Headers->IncludeCategory->Limit;
                $ModelClass = $this->Class->$ModelCategory->Model;

                $Categories = $ModelClass::limit($LimitCategory)->get();

                if(count(get_object_vars($this->InsertModelsCore->Headers->IncludeSubcategory))){
                    $ModelSubcategory = $this->InsertModelsCore->Headers->IncludeSubcategory->Model;
                    $Categories = $ModelClass::with('getHeader'.$ModelSubcategory)->limit($LimitCategory)->get();
                }
            }

            return view('Client.Core.Headers.'.$this->InsertModelsCore->Headers->Code.'.app', [
                'categoryHeader' => $Categories,
                'listMenu' => $this->InsertModelsMain
            ]);
        }
    }

    public function renderFooter()
    {

        if(count(get_object_vars($this->InsertModelsCore))){
            $Categories = [];

            if(count(get_object_vars($this->InsertModelsCore->Footers->IncludeCategory))){

                $ModelCategory = $this->InsertModelsCore->Footers->IncludeCategory->Model;
                $LimitCategory = $this->InsertModelsCore->Footers->IncludeCategory->Limit;
                $ModelClass = $this->Class->$ModelCategory->Model;

                $Categories = $ModelClass::limit($LimitCategory)->get();

                if(count(get_object_vars($this->InsertModelsCore->Footers->IncludeSubcategory))){
                    $ModelSubcategory = $this->InsertModelsCore->Footers->IncludeSubcategory->Model;
                    $Categories = $ModelClass::with('getHeader'.$ModelSubcategory)->limit($LimitCategory)->get();
                }

            }

            return view('Client.Core.Footers.'.$this->InsertModelsCore->Footers->Code.'.app', [
                'categoryFooter' => $Categories,
                'listMenu' => $this->InsertModelsMain
            ]);
        }
    }
}
