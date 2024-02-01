<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT12ContentsTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT12TopicController extends Controller
{
    protected $path = 'uploads/Contents/CONT12/images/';

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

        $data['active'] = $request->active? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive) $data['path_archive'] = $path_archive;

        if(CONT12ContentsTopic::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao cadastradar o item');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT12ContentsTopic  $CONT12ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT12ContentsTopic $CONT12ContentsTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($CONT12ContentsTopic, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($CONT12ContentsTopic, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive){
            storageDelete($CONT12ContentsTopic, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($CONT12ContentsTopic, 'path_archive');
            $data['path_archive'] = null;
        }

        if($CONT12ContentsTopic->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT12ContentsTopic  $CONT12ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT12ContentsTopic $CONT12ContentsTopic)
    {
        storageDelete($CONT12ContentsTopic, 'path_image_icon');
        storageDelete($CONT12ContentsTopic, 'path_archive');

        if($CONT12ContentsTopic->delete()){
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

        $CONT12ContentsTopics = CONT12ContentsTopic::whereIn('id', $request->deleteAll)->get();
        foreach($CONT12ContentsTopics as $CONT12ContentsTopic){
            storageDelete($CONT12ContentsTopic, 'path_image_icon');
            storageDelete($CONT12ContentsTopic, 'path_archive');
        }

        if($deleted = CONT12ContentsTopic::whereIn('id', $request->deleteAll)->delete()){
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
            CONT12ContentsTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
