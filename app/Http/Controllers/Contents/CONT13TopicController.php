<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT13ContentsTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT13TopicController extends Controller
{
    protected $path = 'uploads/Contents/CONT13/images/';

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

        $data['active'] = $request->active ? 1 : 0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(CONT13ContentsTopic::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o tópico');
        }
        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT13ContentsTopic  $CONT13ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT13ContentsTopic $CONT13ContentsTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($CONT13ContentsTopic, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($CONT13ContentsTopic, 'path_image');
            $data['path_image'] = null;
        }

        if($CONT13ContentsTopic->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT13ContentsTopic  $CONT13ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT13ContentsTopic $CONT13ContentsTopic)
    {
        storageDelete($CONT13ContentsTopic, 'path_image');

        if($CONT13ContentsTopic->delete()){
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

        $CONT13ContentsTopics = CONT13ContentsTopic::whereIn('id', $request->deleteAll)->get();
        foreach($CONT13ContentsTopics as $CONT13ContentsTopic){
            storageDelete($CONT13ContentsTopic, 'path_image');
        }

        if($deleted = CONT13ContentsTopic::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' tópicos deletados com sucessso']);
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
            CONT13ContentsTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
