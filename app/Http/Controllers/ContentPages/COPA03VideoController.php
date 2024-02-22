<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA03ContentPagesVideo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA03VideoController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA03/images/';

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

        $data['active'] = $request->active ? 1 : 0;

        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive) $data['path_archive'] = $path_archive;

        if(COPA03ContentPagesVideo::create($data)){
            Session::flash('success', 'Vídeo cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao cadastradar o video');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA03ContentPagesVideo  $COPA03ContentPagesVideo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA03ContentPagesVideo $COPA03ContentPagesVideo)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($COPA03ContentPagesVideo, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($COPA03ContentPagesVideo, 'path_image');
            $data['path_image'] = null;
        }

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive){
            storageDelete($COPA03ContentPagesVideo, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($COPA03ContentPagesVideo, 'path_archive');
            $data['path_archive'] = null;
        }

        if($COPA03ContentPagesVideo->fill($data)->save()){
            Session::flash('success', 'Vídeo atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao atualizar o vídeo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA03ContentPagesVideo  $COPA03ContentPagesVideo
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA03ContentPagesVideo $COPA03ContentPagesVideo)
    {
        storageDelete($COPA03ContentPagesVideo, 'path_image');
        storageDelete($COPA03ContentPagesVideo, 'path_archive');

        if($COPA03ContentPagesVideo->delete()){
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

        $COPA03ContentPagesVideos = COPA03ContentPagesVideo::whereIn('id', $request->deleteAll)->get();
        foreach($COPA03ContentPagesVideos as $COPA03ContentPagesVideo){
            storageDelete($COPA03ContentPagesVideo, 'path_image');
            storageDelete($COPA03ContentPagesVideo, 'path_archive');
        }

        if($deleted = COPA03ContentPagesVideo::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' vídeos deletados com sucessso']);
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
            COPA03ContentPagesVideo::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
