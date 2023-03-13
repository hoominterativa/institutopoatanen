<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT101PortfoliosGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PORT101GalleryController extends Controller
{
    protected $path = 'uploads/Portfolios/PORT101/images/';

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

        $namesImages = $helper->uploadMultipleImage($request, 'path_image', $this->path, null, 100);

        foreach ($namesImages as $namesImage) {
            PORT101PortfoliosGallery::create(['path_image' => $namesImage, 'portfolio_id' => $request->portfolio_id]);
        }

        Session::flash('reopenModal', 'modal-gallery-update-'.$request->portfolio_id);

        return Response::json([
            'status' => 'success',
            'countUploads' => count($namesImages),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT101PortfoliosGallery  $PORT101PortfoliosGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT101PortfoliosGallery $PORT101PortfoliosGallery)
    {
        storageDelete($PORT101PortfoliosGallery, 'path_image');

        if($PORT101PortfoliosGallery->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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
        $PORT101PortfoliosGallerys = PORT101PortfoliosGallery::whereIn('id', $request->deleteAll)->get();
        foreach($PORT101PortfoliosGallerys as $PORT101PortfoliosGallery){
            storageDelete($PORT101PortfoliosGallery, 'path_image');
        }

        if($deleted = PORT101PortfoliosGallery::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
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
            PORT101PortfoliosGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
