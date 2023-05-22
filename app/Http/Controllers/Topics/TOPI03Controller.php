<?php

namespace App\Http\Controllers\Topics;

use Illuminate\Http\Request;
use App\Models\Topics\TOPI03Topics;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Topics\TOPI03TopicsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI03Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI03Topics::sorting()->get();
        $section = TOPI03TopicsSection::first();
        return view('Admin.cruds.Topics.TOPI03.index', [
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
        return view('Admin.cruds.Topics.TOPI03.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI03')
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

        if(TOPI03Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi03.index');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI03Topics  $TOPI03Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI03Topics $TOPI03Topics)
    {
        return view('Admin.cruds.Topics.TOPI03.edit', [
            'topic' => $TOPI03Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI03')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI03Topics  $TOPI03Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI03Topics $TOPI03Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TOPI03Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TOPI03Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($TOPI03Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI03Topics  $TOPI03Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI03Topics $TOPI03Topics)
    {
        storageDelete($TOPI03Topics, 'path_image_icon');

        if($TOPI03Topics->delete()){
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

        $TOPI03Topicss = TOPI03Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI03Topicss as $TOPI03Topics){
            storageDelete($TOPI03Topics, 'path_image_icon');
        }

        if($deleted = TOPI03Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI03Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        return view('Client.pages.Topics.TOPI03.section');
    }
}
