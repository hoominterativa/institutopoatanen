<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI05Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI05Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI05/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI05Topics::sorting()->get();
        return view('Admin.cruds.Topics.TOPI05.index', [
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
        return view('Admin.cruds.Topics.TOPI05.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI05')
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
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image) $data['path_image'] = $path_image;

        if(TOPI05Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi05.index');
        }else{
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI05Topics  $TOPI05Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI05Topics $TOPI05Topics)
    {
        return view('Admin.cruds.Topics.TOPI05.edit', [
            'topic' => $TOPI05Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI05')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI05Topics  $TOPI05Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI05Topics $TOPI05Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image){
            storageDelete($TOPI05Topics, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($TOPI05Topics, 'path_image');
            $data['path_image'] = null;
        }

        if($TOPI05Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI05Topics  $TOPI05Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI05Topics $TOPI05Topics)
    {
        storageDelete($TOPI05Topics, 'path_image');

        if($TOPI05Topics->delete()){
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

        $TOPI05Topicss = TOPI05Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI05Topicss as $TOPI05Topics){
            storageDelete($TOPI05Topics, 'path_image');
        }

        if($deleted = TOPI05Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI05Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        $topics = TOPI05Topics::active()->sorting()->get();
        return view('Client.pages.Topics.TOPI05.section', [
            'topics' => $topics
        ]);
    }
}
