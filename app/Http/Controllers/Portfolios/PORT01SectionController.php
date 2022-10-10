<?php

namespace App\Http\Controllers\Portfolios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT01PortfoliosSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PORT01SectionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        if(PORT01PortfoliosSection::create($data)){
            Session::flash('success', 'Informações cadastrada com sucesso');
        }else{
            Session::flash('success', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT01PortfoliosSection  $PORT01PortfoliosSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT01PortfoliosSection $PORT01PortfoliosSection)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        if($PORT01PortfoliosSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }
}
