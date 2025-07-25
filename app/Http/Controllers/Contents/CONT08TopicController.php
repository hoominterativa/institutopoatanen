<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT08ContentsTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT08TopicController extends Controller
{
    protected $path = 'uploads/Contents/CONT08/images/';

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

        // $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        // if($path_image) $data['path_image'] = $path_image;

        if(CONT08ContentsTopic::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
        }else{
            // Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT08ContentsTopic  $CONT08ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT08ContentsTopic $CONT08ContentsTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        // $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        // if($path_image){
        //     storageDelete($CONT08ContentsTopic, 'path_image');
        //     $data['path_image'] = $path_image;
        // }
        // if($request->delete_path_image && !$path_image){
        //     storageDelete($CONT08ContentsTopic, 'path_image');
        //     $data['path_image'] = null;
        // }

        if($CONT08ContentsTopic->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            // Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT08ContentsTopic  $CONT08ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT08ContentsTopic $CONT08ContentsTopic)
    {
        // storageDelete($CONT08ContentsTopic, 'path_image');

        if($CONT08ContentsTopic->delete()){
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

        $CONT08ContentsTopics = CONT08ContentsTopic::whereIn('id', $request->deleteAll)->get();
        // foreach($CONT08ContentsTopics as $CONT08ContentsTopic){
        //     storageDelete($CONT08ContentsTopic, 'path_image');
        // }

        if($deleted = CONT08ContentsTopic::whereIn('id', $request->deleteAll)->delete()){
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
            CONT08ContentsTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
