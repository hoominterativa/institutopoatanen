<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV12ServicesTopicGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV12TopicGalleryController extends Controller
{
    protected $path = 'uploads/Services/SERV12/images/';

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

        $path_image =  $helper->uploadMultipleImage($request, 'path_image', $this->path, null,100);
        $data['link_video'] = isset($data['link_video']) ? getUri($data['link_video']) : null;

        foreach ($path_image as $image) {
            $data['path_image'] = $image;
            SERV12ServicesTopicGallery::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV12ServicesTopicGallery  $SERV12ServicesTopicGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV12ServicesTopicGallery $SERV12ServicesTopicGallery)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['link_video'] = isset($data['link_video']) ? getUri($data['link_video']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV12ServicesTopicGallery, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV12ServicesTopicGallery, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV12ServicesTopicGallery->fill($data)->save()){
            Session::flash('success', 'Galeria atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a galeria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV12ServicesTopicGallery  $SERV12ServicesTopicGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV12ServicesTopicGallery $SERV12ServicesTopicGallery)
    {
        storageDelete($SERV12ServicesTopicGallery, 'path_image');

        if($SERV12ServicesTopicGallery->delete()){
            Session::flash('success', 'Imagem deletada com sucessso');
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

        $SERV12ServicesTopicGallerys = SERV12ServicesTopicGallery::whereIn('id', $request->deleteAll)->get();
        foreach($SERV12ServicesTopicGallerys as $SERV12ServicesTopicGallery){
            storageDelete($SERV12ServicesTopicGallery, 'path_image');
        }

        if($deleted = SERV12ServicesTopicGallery::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' imagens deletadas com sucessso']);
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
            SERV12ServicesTopicGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
