<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV07ServicesGalleryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV07GalleryServiceController extends Controller
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

        $path_image =  $helper->uploadMultipleImage($request, 'path_image', $this->path, null,100);
        foreach ($path_image as $image) {
            $data['path_image'] = $image;
            SERV07ServicesGalleryService::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV07ServicesGalleryService  $SERV07ServicesGalleryService
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV07ServicesGalleryService $SERV07ServicesGalleryService)
    {
        storageDelete($SERV07ServicesGalleryService, 'path_image');

        if($SERV07ServicesGalleryService->delete()){
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

        $SERV07ServicesGalleryServices = SERV07ServicesGalleryService::whereIn('id', $request->deleteAll)->get();
        foreach($SERV07ServicesGalleryServices as $SERV07ServicesGalleryService){
            storageDelete($SERV07ServicesGalleryService, 'path_image');
        }

        if($deleted = SERV07ServicesGalleryService::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Imagens deletadas com sucessso']);
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
            SERV07ServicesGalleryService::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
