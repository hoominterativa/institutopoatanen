<?php

namespace App\Http\Controllers\Products;

use App\Models\Products\PROD05ProductsGallerySection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PROD05GallerySectionController extends Controller
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

        $path_image =  $helper->uploadMultipleImage($request, 'path_image', $this->path, null,100);

        foreach ($path_image as $image) {
            $data['path_image'] = $image;
            PROD05ProductsGallerySection::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products\PROD05ProductsGallerySection  $PROD05ProductsGallerySection
     * @return \Illuminate\Http\Response
     */
    public function changeList(Request $request, PROD05ProductsGallerySection $PROD05ProductsGallerySection)
    {
        $data = $request->all();
        $PROD05ProductsGallerySection->fill($data)->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD05ProductsGallerySection  $PROD05ProductsGallerySection
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD05ProductsGallerySection $PROD05ProductsGallerySection)
    {
        storageDelete($PROD05ProductsGallerySection, 'path_image');

        if($PROD05ProductsGallerySection->delete()){
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
        $PROD05ProductsGallerySections = PROD05ProductsGallerySection::whereIn('id', $request->deleteAll)->get();
        foreach($PROD05ProductsGallerySections as $PROD05ProductsGallerySection){
            storageDelete($PROD05ProductsGallerySection, 'path_image');
        }

        if($deleted = PROD05ProductsGallerySection::whereIn('id', $request->deleteAll)->delete()){
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
            PROD05ProductsGallerySection::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
