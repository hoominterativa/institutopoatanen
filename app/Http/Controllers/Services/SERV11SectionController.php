<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV11ServicesSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV11SectionController extends Controller
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

        $data['active_section'] = $request->active_section ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;

        if(SERV11ServicesSection::create($data)){
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
     * @param  \App\Models\Services\SERV11ServicesSection  $SERV11ServicesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV11ServicesSection $SERV11ServicesSection)
    {
        $data = $request->all();

        $data['active_section'] = $request->active_section ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;

        if($SERV11ServicesSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
