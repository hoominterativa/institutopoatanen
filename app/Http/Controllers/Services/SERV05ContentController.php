<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV05ServicesContent;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV05ContentController extends Controller
{
    protected $path = 'uploads/Services/SERV05/images/';

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
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(SERV05ServicesContent::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV05ServicesContent  $SERV05ServicesContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV05ServicesContent $SERV05ServicesContent)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV05ServicesContent, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV05ServicesContent, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV05ServicesContent, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV05ServicesContent, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($SERV05ServicesContent->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');;
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV05ServicesContent  $SERV05ServicesContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV05ServicesContent $SERV05ServicesContent)
    {
        storageDelete($SERV05ServicesContent, 'path_image');
        storageDelete($SERV05ServicesContent, 'path_image_icon');

        if($SERV05ServicesContent->delete()){
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

        $SERV05ServicesContents = SERV05ServicesContent::whereIn('id', $request->deleteAll)->get();
        foreach($SERV05ServicesContents as $SERV05ServicesContent){
            storageDelete($SERV05ServicesContent, 'path_image');
            storageDelete($SERV05ServicesContent, 'path_image_icon');
        }

        if($deleted = SERV05ServicesContent::whereIn('id', $request->deleteAll)->delete()){
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
            SERV05ServicesContent::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
