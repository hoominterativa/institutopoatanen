<?php

namespace App\Http\Controllers\Galleries;

use App\Models\Galleries\GALL02GalleriesImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class GALL02ImageController extends Controller
{
    protected $path = 'uploads/Galleries/GALL02/images/';

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

        if(GALL02GalleriesImage::create($data)){
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
     * @param  \App\Models\Galleries\GALL02GalleriesImage  $GALL02GalleriesImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GALL02GalleriesImage $GALL02GalleriesImage)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($GALL02GalleriesImage, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($GALL02GalleriesImage, 'path_image');
            $data['path_image'] = null;
        }

        if($GALL02GalleriesImage->fill($data)->save()){
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
     * @param  \App\Models\Galleries\GALL02GalleriesImage  $GALL02GalleriesImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(GALL02GalleriesImage $GALL02GalleriesImage)
    {
        storageDelete($GALL02GalleriesImage, 'path_image');

        if($GALL02GalleriesImage->delete()){
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
        $GALL02GalleriesImages = GALL02GalleriesImage::whereIn('id', $request->deleteAll)->get();
        foreach($GALL02GalleriesImages as $GALL02GalleriesImage){
            storageDelete($GALL02GalleriesImage, 'path_image');
        }

        if($deleted = GALL02GalleriesImage::whereIn('id', $request->deleteAll)->delete()){
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
            GALL02GalleriesImage::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
