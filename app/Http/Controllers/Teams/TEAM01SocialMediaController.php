<?php

namespace App\Http\Controllers\Teams;

use App\Models\Teams\TEAM01TeamsSocialMedia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TEAM01SocialMediaController extends Controller
{
    protected $path = 'uploads/Teams/TEAM01/images/';

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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(TEAM01TeamsSocialMedia::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o item');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teams\TEAM01TeamsSocialMedia  $TEAM01TeamsSocialMedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TEAM01TeamsSocialMedia $TEAM01TeamsSocialMedia)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TEAM01TeamsSocialMedia, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TEAM01TeamsSocialMedia, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($TEAM01TeamsSocialMedia->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teams\TEAM01TeamsSocialMedia  $TEAM01TeamsSocialMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy(TEAM01TeamsSocialMedia $TEAM01TeamsSocialMedia)
    {
        storageDelete($TEAM01TeamsSocialMedia, 'path_image_icon');

        if($TEAM01TeamsSocialMedia->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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

        $TEAM01TeamsSocialMedias = TEAM01TeamsSocialMedia::whereIn('id', $request->deleteAll)->get();
        foreach($TEAM01TeamsSocialMedias as $TEAM01TeamsSocialMedia){
            storageDelete($TEAM01TeamsSocialMedia, 'path_image_icon');
        }

        if($deleted = TEAM01TeamsSocialMedia::whereIn('id', $request->deleteAll)->delete()){
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
            TEAM01TeamsSocialMedia::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
