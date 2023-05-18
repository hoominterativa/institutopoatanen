<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI102TopicsFeaturedTopics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI102FeaturedTopicsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI102.FeaturedTopics.create');
    }

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

        if(TOPI102TopicsFeaturedTopics::create($data)){
            Session::flash('success', 'Tópico em destaque cadastrado com sucesso');
            return redirect()->route('admin.topi102.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar o Tópico em destaque');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI102TopicsFeaturedTopics  $TOPI102TopicsFeaturedTopics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI102TopicsFeaturedTopics $TOPI102TopicsFeaturedTopics)
    {
        return view('Admin.cruds.Topics.TOPI102.FeaturedTopics.edit', [
            'featuredtopic' => $TOPI102TopicsFeaturedTopics
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI102TopicsFeaturedTopics  $TOPI102TopicsFeaturedTopics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI102TopicsFeaturedTopics $TOPI102TopicsFeaturedTopics)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;

        if($TOPI102TopicsFeaturedTopics->fill($data)->save()){
            Session::flash('success', 'Tópico em destaque atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar o tópico em destaque');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI102TopicsFeaturedTopics  $TOPI102TopicsFeaturedTopics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI102TopicsFeaturedTopics $TOPI102TopicsFeaturedTopics)
    {
        if($TOPI102TopicsFeaturedTopics->delete()){
            Session::flash('success', 'Tópico em destaque deletado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the selected resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {

        if($deleted = TOPI102TopicsFeaturedTopics::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Tópicos em destaque deletados com sucessso']);
        }
    }
    /**
    * Sort record by dragging and dropping
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            TOPI102TopicsFeaturedTopics::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
