<?php

namespace App\Http\Controllers\Blogs;

use App\Models\Blogs\BLOG03BlogsGalleries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Nette\Utils\Json;

class BLOG03GalleriesController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';

    public function store(Request $request) : RedirectResponse
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(BLOG03BlogsGalleries::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
        }else{
            //Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item');
        }
        return redirect()->back();
    }

    public function update(Request $request, BLOG03BlogsGalleries $BLOG03BlogsGalleries) : RedirectResponse
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($BLOG03BlogsGalleries, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($BLOG03BlogsGalleries, 'path_image');
            $data['path_image'] = null;
        }


        if($BLOG03BlogsGalleries->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blogs\BLOG03BlogsGalleries  $BLOG03BlogsGalleries
     * @return \Illuminate\Http\Response
     */
    public function destroy(BLOG03BlogsGalleries $BLOG03BlogsGalleries)
    {
        storageDelete($BLOG03BlogsGalleries, 'path_image');

        if($BLOG03BlogsGalleries->delete()){
            Session::flash('success', 'Item deletado com sucesso');
        }else{
            Session::flash('error', 'Erro ao deletar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the selected resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request) : JsonResponse
    {

        $BLOG03BlogsGalleriess = BLOG03BlogsGalleries::whereIn('id', $request->deleteAll)->get();
        foreach($BLOG03BlogsGalleriess as $BLOG03BlogsGalleries){
            storageDelete($BLOG03BlogsGalleries, 'path_image');
        }

        if($deleted = BLOG03BlogsGalleries::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucesso']);
        }
        return Response::json(['status' => 'error', 'message' => 'Erro ao deletar os itens']);
    }
    /**
    * Sort record by dragging and dropping
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function sorting(Request $request) : JsonResponse
    {
        foreach($request->arrId as $sorting => $id){
            BLOG03BlogsGalleries::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
