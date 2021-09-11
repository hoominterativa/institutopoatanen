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
        if(isset($this->InsertModelsCore->Headers->Code)){
            return view('Client.Core.Headers.'.$this->InsertModelsCore->Headers->Code.'.app', [
                'class' => $this->Class,
                'listMenu' => $this->InsertModelsMain
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
