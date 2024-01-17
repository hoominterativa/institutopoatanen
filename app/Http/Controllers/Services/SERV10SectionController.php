<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV10ServicesSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV10SectionController extends Controller
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

        if(SERV10ServicesSection::create($data)){
            Session::flash('success', 'Serviço cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar o serviço');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV10ServicesSection  $SERV10ServicesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV10ServicesSection $SERV10ServicesSection)
    {
        $data = $request->all();

        $data['active_section'] = $request->active_section ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;

        if($SERV10ServicesSection->fill($data)->save()){
            Session::flash('success', 'Serviço atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar o serviço');
        }
        return redirect()->back();
    }
}
