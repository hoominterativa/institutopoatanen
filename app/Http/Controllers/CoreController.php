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
        return view('Client.Core.Headers.'.$this->InsertModelsCore->Headers->Code.'.app', [
            'class' => $this->Class,
            'listMenu' => $this->InsertModelsMain
        ]);
    }

    public function renderFooter()
    {
        return view('Client.Core.Footers.'.$this->InsertModelsCore->Footers->Code.'.app', [
            // 'categoryFooter' => $Categories,
            'listMenu' => $this->InsertModelsMain
        ]);

    }
}
