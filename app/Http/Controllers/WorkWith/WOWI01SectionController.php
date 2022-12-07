<?php

namespace App\Http\Controllers\WorkWith;

use App\Models\WorkWith\WOWI01WorkWithSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class WOWI01SectionController extends Controller
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

        if(WOWI01WorkWithSection::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkWith\WOWI01WorkWithSection  $WOWI01WorkWithSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WOWI01WorkWithSection $WOWI01WorkWithSection)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;

        if($WOWI01WorkWithSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar Informações');
        }
        return redirect()->back();
    }
}
