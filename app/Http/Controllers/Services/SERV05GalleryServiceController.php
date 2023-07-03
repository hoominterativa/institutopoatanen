<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV05ServicesGalleryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV05GalleryServiceController extends Controller
{
    protected $path = 'uploads/Services/SERV05/images/';

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

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if(SERV05ServicesGalleryService::create($data)){
            Session::flash('success', 'Imagem cadastrada com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar a imagem');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV05ServicesGalleryService  $SERV05ServicesGalleryService
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV05ServicesGalleryService $SERV05ServicesGalleryService)
    {
        storageDelete($SERV05ServicesGalleryService, 'path_image_desktop');
        storageDelete($SERV05ServicesGalleryService, 'path_image_mobile');

        if($SERV05ServicesGalleryService->delete()){
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

        $SERV05ServicesGalleryServices = SERV05ServicesGalleryService::whereIn('id', $request->deleteAll)->get();
        foreach($SERV05ServicesGalleryServices as $SERV05ServicesGalleryService){
            storageDelete($SERV05ServicesGalleryService, 'path_image_desktop');
            storageDelete($SERV05ServicesGalleryService, 'path_image_mobile');
        }

        if($deleted = SERV05ServicesGalleryService::whereIn('id', $request->deleteAll)->delete()){
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
            SERV05ServicesGalleryService::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
