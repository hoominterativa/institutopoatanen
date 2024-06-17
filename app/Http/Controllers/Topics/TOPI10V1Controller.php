<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI10V1Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Topics\TOPI10V1TopicsSection;

class TOPI10V1Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI10V1/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI10V1Topics::sorting()->get();
        $section = TOPI10V1TopicsSection::first();
        return view('Admin.cruds.Topics.TOPI10V1.index', [
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
        return view('Admin.cruds.Topics.TOPI10V1.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI10V1')
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

        if(TOPI10V1Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi10v1.index');
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
     * @param  \App\Models\Topics\TOPI10V1Topics  $TOPI10V1Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI10V1Topics $TOPI10V1Topics)
    {
        return view('Admin.cruds.Topics.TOPI10V1.edit', [
            'topic' => $TOPI10V1Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI10V1')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI10V1Topics  $TOPI10V1Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI10V1Topics $TOPI10V1Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TOPI10V1Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TOPI10V1Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($TOPI10V1Topics, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($TOPI10V1Topics, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($TOPI10V1Topics->fill($data)->save()){
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
     * @param  \App\Models\Topics\TOPI10V1Topics  $TOPI10V1Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI10V1Topics $TOPI10V1Topics)
    {
        storageDelete($TOPI10V1Topics, 'path_image_icon');
        storageDelete($TOPI10V1Topics, 'path_image_box');

        if($TOPI10V1Topics->delete()){
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

        $TOPI10V1Topicss = TOPI10V1Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI10V1Topicss as $TOPI10V1Topics){
            storageDelete($TOPI10V1Topics, 'path_image_icon');
            storageDelete($TOPI10V1Topics, 'path_image_box');
        }

        if($deleted = TOPI10V1Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI10V1Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        $topics = TOPI10V1Topics::active()->sorting()->get();
        $section = TOPI10V1TopicsSection::active()->first();
        return view('Client.pages.Topics.TOPI10V1.section', [
            'topics' => $topics,
            'section' => $section
        ]);
    }
}
