<?php

namespace App\Http\Controllers\Portfolios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT01PortfoliosGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PORT01GalleryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $path = 'uploads/Portfolios/PORT01/images/';
        $helper = new HelperArchive();

        foreach ($data['path_image'] as $key => $value) {
            $path_image = $helper->optimizeImage($request, 'path_image', $path, 200, 80, $key);
            $data['path_image'] = $path_image;
            PORT01PortfoliosGallery::create($data);
        }

        return Response::json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT01PortfoliosGallery  $PORT01PortfoliosGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT01PortfoliosGallery $PORT01PortfoliosGallery)
    {
        Storage::delete($PORT01PortfoliosGallery->path_image);
        if($PORT01PortfoliosGallery->delete()){
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
        $PORT01PortfoliosGallerys = PORT01PortfoliosGallery::whereIn('id', $request->deleteAll)->get();
        foreach($PORT01PortfoliosGallerys as $PORT01PortfoliosGallery){
            Storage::delete($PORT01PortfoliosGallery->path_image);
        }

        if($deleted = PORT01PortfoliosGallery::whereIn('id', $request->deleteAll)->delete()){
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
            PORT01PortfoliosGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
