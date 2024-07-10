<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT05PortfoliosGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PORT05GalleryController extends Controller
{
    protected $path = 'uploads/Portfolios/PORT05/images/';

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

        $data['featured'] = $request->featured?1:0;
        $data['link_video'] = isset($data['link_video']) ? getUri($data['link_video']) : null;

        $path_image =  $helper->uploadMultipleImage($request, 'path_image', $this->path, null,100);

        foreach ($path_image as $image) {
            $data['path_image'] = $image;
            PORT05PortfoliosGallery::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT05PortfoliosGallery  $PORT05PortfoliosGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT05PortfoliosGallery $PORT05PortfoliosGallery)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['featured'] = $request->featured?1:0;
        $data['link_video'] = isset($data['link_video']) ? getUri($data['link_video']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($PORT05PortfoliosGallery, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PORT05PortfoliosGallery, 'path_image');
            $data['path_image'] = null;
        }

        if($PORT05PortfoliosGallery->fill($data)->save()){
            Session::flash('success', 'Galeria atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a galeria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT05PortfoliosGallery  $PORT05PortfoliosGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT05PortfoliosGallery $PORT05PortfoliosGallery)
    {
        storageDelete($PORT05PortfoliosGallery, 'path_image');

        if($PORT05PortfoliosGallery->delete()){
            Session::flash('success', 'Galeria deletada com sucessso');
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

        $PORT05PortfoliosGallerys = PORT05PortfoliosGallery::whereIn('id', $request->deleteAll)->get();
        foreach($PORT05PortfoliosGallerys as $PORT05PortfoliosGallery){
            storageDelete($PORT05PortfoliosGallery, 'path_image');
        }

        if($deleted = PORT05PortfoliosGallery::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' galerias deletados com sucessso']);
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
            PORT05PortfoliosGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
