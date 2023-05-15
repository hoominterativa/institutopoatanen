<?php

namespace App\Http\Controllers\Portals;

use App\Models\Portals\POTA01PortalsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class POTA01SectionController extends Controller
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

        if(POTA01PortalsSection::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Session::flash('success', 'Erro ao cadastradar o informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portals\POTA01PortalsSection  $POTA01PortalsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, POTA01PortalsSection $POTA01PortalsSection)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        if($POTA01PortalsSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }
}
