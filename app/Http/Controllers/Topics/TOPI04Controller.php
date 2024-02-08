<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI04Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Topics\TOPI04TopicsGallery;
use App\Models\Topics\TOPI04TopicsTopicSection;

class TOPI04Controller extends Controller
{
    protected $path = 'uploads/Topic/TOPI04/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI04Topics::sorting()->get();
        return view('Admin.cruds.Topics.TOPI04.index', [
            'topics' => $topics,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI04.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI04')
        ]);
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
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        if($topics = TOPI04Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi04.edit', ['TOPI04Topics' => $topics->id]);
        }else{
            Session::flash('success', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI04Topics  $TOPI04Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI04Topics $TOPI04Topics)
    {
        $topicSections = TOPI04TopicsTopicSection::where('topic_id', $TOPI04Topics->id)->sorting()->get();
        $galleries = TOPI04TopicsGallery::where('topic_id', $TOPI04Topics->id)->sorting()->get();
        return view('Admin.cruds.Topics.TOPI04.edit', [
            'topic' => $TOPI04Topics,
            'topicSections' => $topicSections,
            'galleries' => $galleries,
            'cropSetting' => getCropImage('Topics', 'TOPI04')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI04Topics  $TOPI04Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI04Topics $TOPI04Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        if($TOPI04Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Session::flash('success', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI04Topics  $TOPI04Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI04Topics $TOPI04Topics)
    {

        if($TOPI04Topics->delete()){
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

        $TOPI04Topicss = TOPI04Topics::whereIn('id', $request->deleteAll)->get();

        if($deleted = TOPI04Topics::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Tópicos deletados com sucessso']);
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
            TOPI04Topics::where('id', $id)->update(['sorting' => $sorting]);
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

        $topics = TOPI04Topics::with(['topicSections', 'galleries'])->active()->sorting()->get();

        return view('Client.pages.Topics.TOPI04.section', [
            'topics' => $topics,
        ]);
    }
}
