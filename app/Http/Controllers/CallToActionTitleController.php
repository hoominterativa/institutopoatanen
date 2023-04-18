<?php

namespace App\Http\Controllers;

use App\Models\CallToActionTitle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CallToActionTitleController extends Controller
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

        $data['active_header'] = $request->active_header?1:0;
        $data['active_footer'] = $request->active_footer?1:0;

        if(CallToActionTitle::create($data)){
            Session::flash('success', 'Informação cadastrada com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar Informação');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CallToActionTitle  $CallToActionTitle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CallToActionTitle $CallToActionTitle)
    {
        $data = $request->all();

        $data['active_header'] = $request->active_header?1:0;
        $data['active_footer'] = $request->active_footer?1:0;

        if($CallToActionTitle->fill($data)->save()){
            Session::flash('success', 'Informação atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar Informação');
        }
        return redirect()->back();
    }
}
