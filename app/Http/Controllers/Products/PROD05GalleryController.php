<?php

namespace App\Http\Controllers\Products;

use App\Models\Products\PROD05ProductsGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Products\PROD05Products;
use App\Models\Products\PROD05ProductsGalleryType;

class PROD05GalleryController extends Controller
{
    protected $path = 'uploads/Products/PROD05/images/';

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

        if(!$request->has('gallery_type_id')){
            $galleryType = PROD05ProductsGalleryType::where('color', $data['color'])->first();
            if(!$galleryType){
                $galleryType = PROD05ProductsGalleryType::create(['color' => $data['color'], 'product_id' => $data['product_id'], 'active' => 1]);
            }
            $data['gallery_type_id'] = $galleryType->id;
        }

        $path_image =  $helper->uploadMultipleImage($request, 'path_image', $this->path, null,100);

        foreach ($path_image as $image) {
            $data['path_image'] = $image;
            PROD05ProductsGallery::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products\PROD05ProductsGallery  $PROD05ProductsGallery
     * @return \Illuminate\Http\Response
     */
    public function changeList(Request $request, PROD05ProductsGallery $PROD05ProductsGallery)
    {
        $data = $request->all();
        $PROD05ProductsGallery->fill($data)->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD05ProductsGallery  $PROD05ProductsGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD05ProductsGallery $PROD05ProductsGallery)
    {
        storageDelete($PROD05ProductsGallery, 'path_image');

        if($PROD05ProductsGallery->delete()){
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
        $PROD05ProductsGallerys = PROD05ProductsGallery::whereIn('id', $request->deleteAll)->get();
        foreach($PROD05ProductsGallerys as $PROD05ProductsGallery){
            storageDelete($PROD05ProductsGallery, 'path_image');
        }

        if($deleted = PROD05ProductsGallery::whereIn('id', $request->deleteAll)->delete()){
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
            PROD05ProductsGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    public function getGallery(Request $request)
    {
        $galleries = PROD05ProductsGallery::where('gallery_type_id', $request->id)->get();
        $view = view('Admin.cruds.Products.PROD05.gallery', compact('galleries'))->render();
        return $view;
    }
}
