<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV07ServicesVideo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV07VideoController extends Controller
{
    protected $path = 'uploads/Services/SERV07/images/';

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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(SERV07ServicesVideo::create($data)){
            Session::flash('success', 'Vídeo cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o vídeo');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV07ServicesVideo  $SERV07ServicesVideo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV07ServicesVideo $SERV07ServicesVideo)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV07ServicesVideo, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV07ServicesVideo, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV07ServicesVideo->fill($data)->save()){
            Session::flash('success', 'Vídeo atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o vídeo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV07ServicesVideo  $SERV07ServicesVideo
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV07ServicesVideo $SERV07ServicesVideo)
    {
        storageDelete($SERV07ServicesVideo, 'path_image');

        if($SERV07ServicesVideo->delete()){
            Session::flash('success', 'Vídeo deletado com sucessso');
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

        $SERV07ServicesVideos = SERV07ServicesVideo::whereIn('id', $request->deleteAll)->get();
        foreach($SERV07ServicesVideos as $SERV07ServicesVideo){
            storageDelete($SERV07ServicesVideo, 'path_image');
        }

        if($deleted = SERV07ServicesVideo::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Vídeos deletados com sucessso']);
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
            SERV07ServicesVideo::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
