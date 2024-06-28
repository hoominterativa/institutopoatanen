<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV12ServicesGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV12GalleryController extends Controller
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

        $data['active'] = $request->active ? 1 : 0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(SERV12ServicesGallery::create($data)){
            Session::flash('success', 'Galeria cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o galeria');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV12ServicesGallery  $SERV12ServicesGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV12ServicesGallery $SERV12ServicesGallery)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV12ServicesGallery, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV12ServicesGallery, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV12ServicesGallery->fill($data)->save()){
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
     * @param  \App\Models\Services\SERV12ServicesGallery  $SERV12ServicesGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV12ServicesGallery $SERV12ServicesGallery)
    {
        storageDelete($SERV12ServicesGallery, 'path_image');

        if($SERV12ServicesGallery->delete()){
            Session::flash('success', 'Galeria deletada com sucessso');
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

        $SERV12ServicesGallerys = SERV12ServicesGallery::whereIn('id', $request->deleteAll)->get();
        foreach($SERV12ServicesGallerys as $SERV12ServicesGallery){
            storageDelete($SERV12ServicesGallery, 'path_image');
        }

        if($deleted = SERV12ServicesGallery::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' galerias deletados com sucessso']);
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
            SERV12ServicesGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
