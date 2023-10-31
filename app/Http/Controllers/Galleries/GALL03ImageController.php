<?php

namespace App\Http\Controllers\Galleries;

use App\Models\Galleries\GALL03GalleriesImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class GALL03ImageController extends Controller
{
    protected $path = 'uploads/Galleries/GALL03/images/';

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
            GALL03GalleriesImage::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galleries\GALL03GalleriesImage  $GALL03GalleriesImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(GALL03GalleriesImage $GALL03GalleriesImage)
    {
        storageDelete($GALL03GalleriesImage, 'path_image');

        if($GALL03GalleriesImage->delete()){
            Session::flash('success', 'Imagem deletado com sucessso');
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
        $GALL03GalleriesImages = GALL03GalleriesImage::whereIn('id', $request->deleteAll)->get();
        foreach($GALL03GalleriesImages as $GALL03GalleriesImage){
            storageDelete($GALL03GalleriesImage, 'path_image');
        }

        if($deleted = GALL03GalleriesImage::whereIn('id', $request->deleteAll)->delete()){
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
            GALL03GalleriesImage::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
