<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI01TopicsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI01SectionController extends Controller
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

        if(TOPI01TopicsSection::create($data)){
            Session::flash('success', 'Informações cadastrado com sucesso');
        }else{
            Session::flash('success', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI01TopicsSection  $TOPI01TopicsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI01TopicsSection $TOPI01TopicsSection)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        if($TOPI01TopicsSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizado com sucesso');
        }else{
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }
}
