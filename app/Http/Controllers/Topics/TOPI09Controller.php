<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI09Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI09Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI09/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI09Topics::sorting()->get();
        return view('Admin.cruds.Topics.TOPI09.index', [
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
        return view('Admin.cruds.Topics.TOPI09.create',[
            'cropSetting' => getCropImage('Topics', 'TOPI09')
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

        if(TOPI09Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi09.index');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI09Topics  $TOPI09Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI09Topics $TOPI09Topics)
    {
        return view('Admin.cruds.Topics.TOPI09.edit', [
            'topic' => $TOPI09Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI09')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI09Topics  $TOPI09Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI09Topics $TOPI09Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TOPI09Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TOPI09Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($TOPI09Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI09Topics  $TOPI09Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI09Topics $TOPI09Topics)
    {
        storageDelete($TOPI09Topics, 'path_image_icon');

        if($TOPI09Topics->delete()){
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

        $TOPI09Topicss = TOPI09Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI09Topicss as $TOPI09Topics){
            storageDelete($TOPI09Topics, 'path_image_icon');
        }

        if($deleted = TOPI09Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI09Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        $topics = TOPI09Topics::active()->sorting()->get();
        return view('Client.pages.Topics.TOPI09.section', [
            'topics' => $topics
        ]);
    }
}
