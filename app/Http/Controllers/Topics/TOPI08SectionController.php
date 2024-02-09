<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI08TopicsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI08SectionController extends Controller
{
    protected $path = 'uploads/Topics/TOPI08/images/';

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        if(TOPI08TopicsSection::create($data)){
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
     * @param  \App\Models\Topics\TOPI08TopicsSection  $TOPI08TopicsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI08TopicsSection $TOPI08TopicsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        if($TOPI08TopicsSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
