<?php

namespace App\Http\Controllers\Units;

use App\Models\Units\UNIT03UnitsGalleryContent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT03GalleryContentController extends Controller
{
    protected $path = 'uploads/Units/UNIT03/images/';

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

        if(UNIT03UnitsGalleryContent::create($data)){
            Session::flash('success', 'Imagem cadastrada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar a imagem');
        }
        Session::flash('reopenModal', ['modal-galleryContent-create-'.$request->content_id, 'modal-content-update-'.$request->content_id]);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT03UnitsGalleryContent  $UNIT03UnitsGalleryContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT03UnitsGalleryContent $UNIT03UnitsGalleryContent)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($UNIT03UnitsGalleryContent, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($UNIT03UnitsGalleryContent, 'path_image');
            $data['path_image'] = null;
        }

        if($UNIT03UnitsGalleryContent->fill($data)->save()){
            Session::flash('success', 'Imagem atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a imagem');
        }
        Session::flash('reopenModal', ['modal-galleryContent-create-'.$request->content_id, 'modal-content-update-'.$request->content_id]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT03UnitsGalleryContent  $UNIT03UnitsGalleryContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT03UnitsGalleryContent $UNIT03UnitsGalleryContent)
    {
        storageDelete($UNIT03UnitsGalleryContent, 'path_image');

        if($UNIT03UnitsGalleryContent->delete()){
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

        $UNIT03UnitsGalleryContents = UNIT03UnitsGalleryContent::whereIn('id', $request->deleteAll)->get();
        foreach($UNIT03UnitsGalleryContents as $UNIT03UnitsGalleryContent){
            storageDelete($UNIT03UnitsGalleryContent, 'path_image');
        }

        if($deleted = UNIT03UnitsGalleryContent::whereIn('id', $request->deleteAll)->delete()){
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
            UNIT03UnitsGalleryContent::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
