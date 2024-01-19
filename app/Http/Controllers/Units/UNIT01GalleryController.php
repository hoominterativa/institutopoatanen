<?php

namespace App\Http\Controllers\Units;

use App\Models\Units\UNIT01UnitsGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT01GalleryController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';

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
            UNIT01UnitsGallery::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT01UnitsGallery  $UNIT01UnitsGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT01UnitsGallery $UNIT01UnitsGallery)
    {
        storageDelete($UNIT01UnitsGallery, 'path_image');

        if($UNIT01UnitsGallery->delete()){
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

        $UNIT01UnitsGallerys = UNIT01UnitsGallery::whereIn('id', $request->deleteAll)->get();
        foreach($UNIT01UnitsGallerys as $UNIT01UnitsGallery){
            storageDelete($UNIT01UnitsGallery, 'path_image');
        }

        if($deleted = UNIT01UnitsGallery::whereIn('id', $request->deleteAll)->delete()){
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
            UNIT01UnitsGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
