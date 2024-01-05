<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI11Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Topics\TOPI11TopicsSection;

class TOPI11Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI11Topics::sorting()->get();
        $section = TOPI11TopicsSection::first();

        return view('Admin.cruds.Topics.TOPI11.index', [
            'topics' => $topics,
            'section' => $section,
            'cropSetting' => getCropImage('Topics', 'TOPI11')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI11.create');
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

        $data['active'] = $request->active? 1 : 0;

        if(TOPI11Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi11.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI11Topics  $TOPI11Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI11Topics $TOPI11Topics)
    {
        return view('Admin.cruds.Topics.TOPI11.edit',[
            'topic' => $TOPI11Topics
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI11Topics  $TOPI11Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI11Topics $TOPI11Topics)
    {
        $data = $request->all();

        $data['active'] = $request->active? 1 : 0;

        if($TOPI11Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI11Topics  $TOPI11Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI11Topics $TOPI11Topics)
    {
        if($TOPI11Topics->delete()){
            Session::flash('success', 'Tópico deletado com sucessso');
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
        if($deleted = TOPI11Topics::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' tópicos deletados com sucessso']);
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
            TOPI11Topics::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $topics = TOPI11Topics::active()->sorting()->get();
        $section = TOPI11TopicsSection::active()->first();
        return view('Client.pages.Topics.TOPI11.section',[
            'topics' => $topics,
            'section' => $section
        ]);
    }
}
