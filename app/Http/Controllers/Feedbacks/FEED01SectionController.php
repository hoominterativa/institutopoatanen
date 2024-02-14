<?php

namespace App\Http\Controllers\Feedbacks;

use App\Models\Feedbacks\FEED01FeedbacksSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class FEED01SectionController extends Controller
{
    protected $path = 'uploads/Feedbacks/FEED01/images/';

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

        $data['active'] = $request->active? 1 : 0;

        if(FEED01FeedbacksSection::create($data)){
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
     * @param  \App\Models\Feedbacks\FEED01FeedbacksSection  $FEED01FeedbacksSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FEED01FeedbacksSection $FEED01FeedbacksSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active? 1 : 0;

        if($FEED01FeedbacksSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
