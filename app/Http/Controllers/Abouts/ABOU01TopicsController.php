<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU01AboutsTopics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU01TopicsController extends Controller
{
    protected $path = 'uploads/Abouts/ABOU01/images/';
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

        if(ABOU01AboutsTopics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao cadastradar tópico');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU01AboutsTopics  $ABOU01AboutsTopics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU01AboutsTopics $ABOU01AboutsTopics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($ABOU01AboutsTopics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($ABOU01AboutsTopics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($ABOU01AboutsTopics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao atualizar tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Abouts\ABOU01AboutsTopics  $ABOU01AboutsTopics
     * @return \Illuminate\Http\Response
     */
    public function destroy(ABOU01AboutsTopics $ABOU01AboutsTopics)
    {
        storageDelete($ABOU01AboutsTopics, 'path_image_icon');

        if($ABOU01AboutsTopics->delete()){
            Session::flash('success', 'Tópico deletado com sucessso');
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
        $ABOU01AboutsTopicss = ABOU01AboutsTopics::whereIn('id', $request->deleteAll)->get();
        foreach($ABOU01AboutsTopicss as $ABOU01AboutsTopics){
            storageDelete($ABOU01AboutsTopics, 'path_image_icon');
        }

        if($deleted = ABOU01AboutsTopics::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Tópicos deletados com sucessso']);
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
            ABOU01AboutsTopics::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
