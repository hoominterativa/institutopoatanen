<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI10Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Topics\TOPI10TopicsSection;

class TOPI10Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI10/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI10Topics::sorting()->get();
        $section = TOPI10TopicsSection::first();
        return view('Admin.cruds.Topics.TOPI10.index', [
            'topics' => $topics,
            'section' => $section
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI10.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI10')
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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        if(TOPI10Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi10.index');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI10Topics  $TOPI10Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI10Topics $TOPI10Topics)
    {
        return view('Admin.cruds.Topics.TOPI10.edit', [
            'topic' => $TOPI10Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI10')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI10Topics  $TOPI10Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI10Topics $TOPI10Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TOPI10Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TOPI10Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($TOPI10Topics, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($TOPI10Topics, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($TOPI10Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI10Topics  $TOPI10Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI10Topics $TOPI10Topics)
    {
        storageDelete($TOPI10Topics, 'path_image_icon');
        storageDelete($TOPI10Topics, 'path_image_box');

        if($TOPI10Topics->delete()){
            Session::flash('success', 'Tópicos deletados com sucessso');
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

        $TOPI10Topicss = TOPI10Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI10Topicss as $TOPI10Topics){
            storageDelete($TOPI10Topics, 'path_image_icon');
            storageDelete($TOPI10Topics, 'path_image_box');
        }

        if($deleted = TOPI10Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI10Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        return view('Client.pages.Topics.TOPI10.section');
    }
}
