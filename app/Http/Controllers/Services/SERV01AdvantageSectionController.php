<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV01ServicesAdvantageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SERV01AdvantageSectionController extends Controller
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
        if(SERV01ServicesAdvantageSection::create($data)){
            Session::flash('success', 'Informações cadastrado com sucesso');
        }else{
            Session::flash('success', 'Erro ao cadastradar Informações');
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01ServicesAdvantageSection  $SERV01ServicesAdvantageSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01ServicesAdvantageSection $SERV01ServicesAdvantageSection)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        if($SERV01ServicesAdvantageSection->fill($data)->save()){
            Session::flash('success', 'Infomações atualizadas com sucesso');
        }else{
            Session::flash('success', 'Erro ao atualizar informações');
        }

        return redirect()->back();
    }
}
