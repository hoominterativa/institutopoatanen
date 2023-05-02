<?php

namespace App\Http\Controllers\Products;

use App\Models\Products\PROD02ProductsGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PROD02GalleryController extends Controller
{
    protected $path = 'uploads/Products/PROD02/images/';

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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(PROD02ProductsGallery::create($data)){
            Session::flash('success', 'Imagem cadastrada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar a imagem');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD02ProductsGallery  $PROD02ProductsGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PROD02ProductsGallery $PROD02ProductsGallery)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($PROD02ProductsGallery, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PROD02ProductsGallery, 'path_image');
            $data['path_image'] = null;
        }

        if($PROD02ProductsGallery->fill($data)->save()){
            Session::flash('success', 'Imagem atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a imagem');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD02ProductsGallery  $PROD02ProductsGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD02ProductsGallery $PROD02ProductsGallery)
    {
        storageDelete($PROD02ProductsGallery, 'path_image');

        if($PROD02ProductsGallery->delete()){
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
        $PROD02ProductsGallerys = PROD02ProductsGallery::whereIn('id', $request->deleteAll)->get();
        foreach($PROD02ProductsGallerys as $PROD02ProductsGallery){
            storageDelete($PROD02ProductsGallery, 'path_image');
        }

        if($deleted = PROD02ProductsGallery::whereIn('id', $request->deleteAll)->delete()){
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
            PROD02ProductsGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
