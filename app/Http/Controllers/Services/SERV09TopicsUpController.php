<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV09ServicesTopicsUp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV09TopicsUpController extends Controller
{
    protected $path = 'uploads/Services/SERV09/images/';

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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;


        if(SERV09ServicesTopicsUp::create($data)){
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
     * @param  \App\Models\Services\SERV09ServicesTopicsUp  $SERV09ServicesTopicsUp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV09ServicesTopicsUp $SERV09ServicesTopicsUp)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV09ServicesTopicsUp, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV09ServicesTopicsUp, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV09ServicesTopicsUp->fill($data)->save()){
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
     * @param  \App\Models\Services\SERV09ServicesTopicsUp  $SERV09ServicesTopicsUp
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV09ServicesTopicsUp $SERV09ServicesTopicsUp)
    {
        storageDelete($SERV09ServicesTopicsUp, 'path_image');

        if($SERV09ServicesTopicsUp->delete()){
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

        $SERV09ServicesTopicsUps = SERV09ServicesTopicsUp::whereIn('id', $request->deleteAll)->get();
        foreach($SERV09ServicesTopicsUps as $SERV09ServicesTopicsUp){
            storageDelete($SERV09ServicesTopicsUp, 'path_image');
        }

        if($deleted = SERV09ServicesTopicsUp::whereIn('id', $request->deleteAll)->delete()){
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
            SERV09ServicesTopicsUp::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
