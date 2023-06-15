<?php

namespace App\Http\Controllers\Units;

use App\Models\Units\UNIT03UnitsContent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Units\UNIT03UnitsGalleryContent;

class UNIT03ContentController extends Controller
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

        $data['active'] = $request->active?1:0;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if(UNIT03UnitsContent::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT03UnitsContent  $UNIT03UnitsContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT03UnitsContent $UNIT03UnitsContent)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($UNIT03UnitsContent, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($UNIT03UnitsContent, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($UNIT03UnitsContent, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($UNIT03UnitsContent, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($UNIT03UnitsContent, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($UNIT03UnitsContent, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($UNIT03UnitsContent->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT03UnitsContent  $UNIT03UnitsContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT03UnitsContent $UNIT03UnitsContent)
    {
        $galleries = UNIT03UnitsGalleryContent::where('content_id', $UNIT03UnitsContent->id)->get();
        foreach($galleries as $gallery){
            storageDelete($gallery, 'path_image');
            $gallery->delete();
        }

        storageDelete($UNIT03UnitsContent, 'path_image');
        storageDelete($UNIT03UnitsContent, 'path_image_desktop');
        storageDelete($UNIT03UnitsContent, 'path_image_mobile');

        if($UNIT03UnitsContent->delete()){
            Session::flash('success', 'Conteúdo deletado com sucessso');
        }
        return redirect()->back();
    }

    /**
     * Remove the selected resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {

        $UNIT03UnitsContents = UNIT03UnitsContent::whereIn('id', $request->deleteAll)->get();
        foreach($UNIT03UnitsContents as $UNIT03UnitsContent){
            
            $galleries = UNIT03UnitsGalleryContent::where('content_id', $UNIT03UnitsContent->id)->get();
            foreach($galleries as $gallery){
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }

            storageDelete($UNIT03UnitsContent, 'path_image');
            storageDelete($UNIT03UnitsContent, 'path_image_mobile');
            storageDelete($UNIT03UnitsContent, 'path_image_desktop');
        }

        if($deleted = UNIT03UnitsContent::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Conteúdos deletados com sucessso']);
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
            UNIT03UnitsContent::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
