<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT04PortfoliosGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PORT04GalleryController extends Controller
{
    protected $path = 'uploads/Portfolios/PORT04/images/';

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
            PORT04PortfoliosGallery::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT04PortfoliosGallery  $PORT04PortfoliosGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT04PortfoliosGallery $PORT04PortfoliosGallery)
    {
        storageDelete($PORT04PortfoliosGallery, 'path_image');

        if($PORT04PortfoliosGallery->delete()){
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

        $PORT04PortfoliosGallerys = PORT04PortfoliosGallery::whereIn('id', $request->deleteAll)->get();
        foreach($PORT04PortfoliosGallerys as $PORT04PortfoliosGallery){
            storageDelete($PORT04PortfoliosGallery, 'path_image');
        }

        if($deleted = PORT04PortfoliosGallery::whereIn('id', $request->deleteAll)->delete()){
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
            PORT04PortfoliosGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
