<?php

namespace App\Http\Controllers\WorkWith;

use App\Models\WorkWith\WOWI01WorkWithTopicSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class WOWI01TopicSectionController extends Controller
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

        if(WOWI01WorkWithTopicSection::create($data)){
            Session::flash('success', 'Informações cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkWith\WOWI01WorkWithTopicSection  $WOWI01WorkWithTopicSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WOWI01WorkWithTopicSection $WOWI01WorkWithTopicSection)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;

        if($WOWI01WorkWithTopicSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }
}
