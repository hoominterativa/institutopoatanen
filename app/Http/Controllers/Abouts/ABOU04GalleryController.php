<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU04AboutsGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU04GalleryController extends Controller
{
    protected $path = 'uploads/Abouts/ABOU04/images/';

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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(ABOU04AboutsGallery::create($data)){
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
     * @param  \App\Models\Abouts\ABOU04AboutsGallery  $ABOU04AboutsGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU04AboutsGallery $ABOU04AboutsGallery)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($ABOU04AboutsGallery, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($ABOU04AboutsGallery, 'path_image');
            $data['path_image'] = null;
        }

        if($ABOU04AboutsGallery->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a imagem');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Abouts\ABOU04AboutsGallery  $ABOU04AboutsGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(ABOU04AboutsGallery $ABOU04AboutsGallery)
    {
        storageDelete($ABOU04AboutsGallery, 'path_image');

        if($ABOU04AboutsGallery->delete()){
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

        $ABOU04AboutsGallerys = ABOU04AboutsGallery::whereIn('id', $request->deleteAll)->get();
        foreach($ABOU04AboutsGallerys as $ABOU04AboutsGallery){
            storageDelete($ABOU04AboutsGallery, 'path_image');
        }

        if($deleted = ABOU04AboutsGallery::whereIn('id', $request->deleteAll)->delete()){
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
            ABOU04AboutsGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
