<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI06Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI06Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI06Topics::sorting()->get();
        return view('Admin.cruds.Topics.TOPI06.index', [
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
        return view('Admin.cruds.Topics.TOPI06.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI06')
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
        $path = 'uploads/Topics/TOPI06/images/';
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_icon_button = $helper->optimizeImage($request, 'path_image_icon_button', $path, null,100);
        if($path_image_icon_button) $data['path_image_icon_button'] = $path_image_icon_button;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if(TOPI06Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi06.index');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_icon_button);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI06Topics  $TOPI06Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI06Topics $TOPI06Topics)
    {
        return view('Admin.cruds.Topics.TOPI06.edit', [
            'topic' => $TOPI06Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI06')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI06Topics  $TOPI06Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI06Topics $TOPI06Topics)
    {
        $data = $request->all();
        $path = 'uploads/Topics/TOPI06/images/';
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $path, null,100);
        if($path_image_icon){
            storageDelete($TOPI06Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TOPI06Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_icon_button = $helper->optimizeImage($request, 'path_image_icon_button', $path, null,100);
        if($path_image_icon_button){
            storageDelete($TOPI06Topics, 'path_image_icon_button');
            $data['path_image_icon_button'] = $path_image_icon_button;
        }
        if($request->delete_path_image_icon_button && !$path_image_icon_button){
            storageDelete($TOPI06Topics, 'path_image_icon_button');
            $data['path_image_icon_button'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $path, null,100);
        if($path_image_desktop){
            storageDelete($TOPI06Topics, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($TOPI06Topics, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $path, null,100);
        if($path_image_mobile){
            storageDelete($TOPI06Topics, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($TOPI06Topics, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($TOPI06Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_icon_button);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI06Topics  $TOPI06Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI06Topics $TOPI06Topics)
    {
        storageDelete($TOPI06Topics, 'path_image_icon');
        storageDelete($TOPI06Topics, 'path_image_icon_button');
        storageDelete($TOPI06Topics, 'path_image_desktop');
        storageDelete($TOPI06Topics, 'path_image_mobile');

        if($TOPI06Topics->delete()){
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
        $TOPI06Topicss = TOPI06Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI06Topicss as $TOPI06Topics){
            storageDelete($TOPI06Topics, 'path_image_icon');
            storageDelete($TOPI06Topics, 'path_image_icon_button');
            storageDelete($TOPI06Topics, 'path_image_desktop');
            storageDelete($TOPI06Topics, 'path_image_mobile');
        }

        if($deleted = TOPI06Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI06Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        return view('Client.pages.Topics.TOPI06.section');
    }
}
