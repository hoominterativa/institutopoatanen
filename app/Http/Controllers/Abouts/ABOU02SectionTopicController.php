<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU02AboutsSectionTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU02SectionTopicController extends Controller
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

        if(ABOU02AboutsSectionTopic::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU02AboutsSectionTopic  $ABOU02AboutsSectionTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU02AboutsSectionTopic $ABOU02AboutsSectionTopic)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        if($ABOU02AboutsSectionTopic->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
