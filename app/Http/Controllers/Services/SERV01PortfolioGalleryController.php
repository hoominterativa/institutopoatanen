<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV01ServicesPortfolioGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SERV01PortfolioGalleryController extends Controller
{
    protected $path = 'uploads/Services/SERV01/images/';
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $helper = new HelperArchive();
        $namesImages = $helper->uploadMultipleImage($request, 'path_image', $this->path);

        foreach ($namesImages as $namesImage) {
            SERV01ServicesPortfolioGallery::create(['path_image' => $namesImage, 'portfolio_id' => $request->portfolio_id]);
        }

        Session::flash('reopenModal', 'modal-portfolio-update-'.$request->portfolio_id);

        return Response::json([
            'status' => 'success',
            'countUploads' => count($namesImages),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV01ServicesPortfolioGallery  $SERV01ServicesPortfolioGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV01ServicesPortfolioGallery $SERV01ServicesPortfolioGallery)
    {
        storageDelete($SERV01ServicesPortfolioGallery, 'path_image');
        if($SERV01ServicesPortfolioGallery->delete()){
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
        $SERV01ServicesPortfolioGallerys = SERV01ServicesPortfolioGallery::whereIn('id', $request->deleteAll)->get();
        foreach($SERV01ServicesPortfolioGallerys as $SERV01ServicesPortfolioGallery){
            storageDelete($SERV01ServicesPortfolioGallery, 'path_image');
        }

        if($deleted = SERV01ServicesPortfolioGallery::whereIn('id', $request->deleteAll)->delete()){
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
            SERV01ServicesPortfolioGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
