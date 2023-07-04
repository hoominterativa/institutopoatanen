<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT11ContentsGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT11GalleryController extends Controller
{
    protected $path = 'uploads/Contents/CONT11/images/';

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
            CONT11ContentsGallery::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT11ContentsGallery  $CONT11ContentsGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT11ContentsGallery $CONT11ContentsGallery)
    {
        storageDelete($CONT11ContentsGallery, 'path_image');

        if($CONT11ContentsGallery->delete()){
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

        $CONT11ContentsGallerys = CONT11ContentsGallery::whereIn('id', $request->deleteAll)->get();
        foreach($CONT11ContentsGallerys as $CONT11ContentsGallery){
            storageDelete($CONT11ContentsGallery, 'path_image');
        }

        if($deleted = CONT11ContentsGallery::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Imagens deletados com sucessso']);
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
            CONT11ContentsGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
