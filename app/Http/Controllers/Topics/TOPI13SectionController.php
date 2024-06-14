<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI13TopicsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI13SectionController extends Controller
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

        $data['active'] = $request->active ? 1 : 0;

        if(TOPI13TopicsSection::create($data)){
            Session::flash('success', 'Seção cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI13TopicsSection  $TOPI13TopicsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI13TopicsSection $TOPI13TopicsSection)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($TOPI13TopicsSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
