<?php

namespace App\Http\Controllers\WorkWith;

use App\Models\WorkWith\WOWI01WorkWithTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class WOWI01TopicController extends Controller
{
    protected $path = 'uploads/WorkWith/WOWI01/images/';

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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null, 100);
        if($path_image_thumbnail) $data['path_image_thumbnail'] = $path_image_thumbnail;

        $data['active'] = $request->active?1:0;
        $data['link'] = getUri($request->link);

        if(WOWI01WorkWithTopic::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_thumbnail);
            Session::flash('error', 'Erro ao cadastradar o item');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkWith\WOWI01WorkWithTopic  $WOWI01WorkWithTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WOWI01WorkWithTopic $WOWI01WorkWithTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon){
            storageDelete($WOWI01WorkWithTopic, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($WOWI01WorkWithTopic, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null, 100);
        if($path_image_thumbnail){
            storageDelete($WOWI01WorkWithTopic, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = $path_image_thumbnail;
        }
        if($request->delete_path_image_thumbnail && !$path_image_thumbnail){
            storageDelete($WOWI01WorkWithTopic, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = null;
        }

        $data['active'] = $request->active?1:0;
        $data['link'] = getUri($request->link);

        if($WOWI01WorkWithTopic->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_thumbnail);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkWith\WOWI01WorkWithTopic  $WOWI01WorkWithTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(WOWI01WorkWithTopic $WOWI01WorkWithTopic)
    {
        storageDelete($WOWI01WorkWithTopic, 'path_image_icon');
        storageDelete($WOWI01WorkWithTopic, 'path_image_thumbnail');

        if($WOWI01WorkWithTopic->delete()){
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
        $WOWI01WorkWithTopics = WOWI01WorkWithTopic::whereIn('id', $request->deleteAll)->get();
        foreach($WOWI01WorkWithTopics as $WOWI01WorkWithTopic){
            storageDelete($WOWI01WorkWithTopic, 'path_image_icon');
            storageDelete($WOWI01WorkWithTopic, 'path_image_thumbnail');
        }

        if($deleted = WOWI01WorkWithTopic::whereIn('id', $request->deleteAll)->delete()){
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
            WOWI01WorkWithTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
