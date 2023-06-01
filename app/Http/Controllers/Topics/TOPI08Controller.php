<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI08Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Topics\TOPI08TopicsSection;

class TOPI08Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI08/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI08Topics::sorting()->get();
        $section = TOPI08TopicsSection::first();
        return view('Admin.cruds.Topics.TOPI08.index', [
            'topics' => $topics,
            'section' => $section,
            'cropSetting' => getCropImage('Topics', 'TOPI08')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI08.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI08')
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

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        if(TOPI08Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi08.index');
        }else{
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI08Topics  $TOPI08Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI08Topics $TOPI08Topics)
    {
        return view('Admin.cruds.Topics.TOPI08.edit', [
            'topic' => $TOPI08Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI08')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI08Topics  $TOPI08Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI08Topics $TOPI08Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($TOPI08Topics, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($TOPI08Topics, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($TOPI08Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI08Topics  $TOPI08Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI08Topics $TOPI08Topics)
    {
        storageDelete($TOPI08Topics, 'path_image_box');

        if($TOPI08Topics->delete()){
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
        $TOPI08Topicss = TOPI08Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI08Topicss as $TOPI08Topics){
            storageDelete($TOPI08Topics, 'path_image_box');
        }

        if($deleted = TOPI08Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI08Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        return view('Client.Pages.Topics.TOPI08.section');
    }
}
