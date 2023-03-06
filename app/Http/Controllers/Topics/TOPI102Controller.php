<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI102Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI102Controller extends Controller
{   
    protected $path = 'uploads/Topics/TOPI102/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI102Topics::sorting()->paginate(6);

        return view('Admin.cruds.Topics.TOPI102.index', [
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
        return view('Admin.cruds.Topics.TOPI102.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI102')
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

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;


        if(TOPI102Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi102.index');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI102Topics  $TOPI102Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI102Topics $TOPI102Topics)
    {
        return view('Admin.cruds.Topics.TOPI102.edit',[
            'topic' => $TOPI102Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI102')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI102Topics  $TOPI102Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI102Topics $TOPI102Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop){
            storageDelete($TOPI102Topics, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($TOPI102Topics, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile){
            storageDelete($TOPI102Topics, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($TOPI102Topics, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }
       

        if($TOPI102Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
            return redirect()->route('admin.topi102.index');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI102Topics  $TOPI102Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI102Topics $TOPI102Topics)
    {
        storageDelete($TOPI102Topics, 'path_image_desktop');
        storageDelete($TOPI102Topics, 'path_image_mobile');

        if($TOPI102Topics->delete()){
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
        $TOPI102Topicss = TOPI102Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI102Topicss as $TOPI102Topics){
            storageDelete($TOPI102Topics, 'path_image_desktop');
            storageDelete($TOPI102Topics, 'path_image_mobile');
        }

        if($deleted = TOPI102Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI102Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        return view('Client.pages.Topics.TOPI102.section');
    }
}
