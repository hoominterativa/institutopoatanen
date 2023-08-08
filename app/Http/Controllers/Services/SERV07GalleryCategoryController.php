<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV07ServicesGalleryCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV07GalleryCategoryController extends Controller
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
            SERV07ServicesGalleryCategory::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV07ServicesGalleryCategory  $SERV07ServicesGalleryCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV07ServicesGalleryCategory $SERV07ServicesGalleryCategory)
    {
        storageDelete($SERV07ServicesGalleryCategory, 'path_image');

        if($SERV07ServicesGalleryCategory->delete()){
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

        $SERV07ServicesGalleryCategorys = SERV07ServicesGalleryCategory::whereIn('id', $request->deleteAll)->get();
        foreach($SERV07ServicesGalleryCategorys as $SERV07ServicesGalleryCategory){
            storageDelete($SERV07ServicesGalleryCategory, 'path_image');
        }

        if($deleted = SERV07ServicesGalleryCategory::whereIn('id', $request->deleteAll)->delete()){
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
            SERV07ServicesGalleryCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
