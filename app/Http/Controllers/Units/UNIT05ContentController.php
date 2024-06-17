<?php

namespace App\Http\Controllers\Units;

use App\Models\Units\UNIT05UnitsContent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT05ContentController extends Controller
{
    protected $path = 'uploads/Units/UNIT05/images/';

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

        if(UNIT05UnitsContent::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT05UnitsContent  $UNIT05UnitsContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT05UnitsContent $UNIT05UnitsContent)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($UNIT05UnitsContent, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($UNIT05UnitsContent, 'path_image');
            $data['path_image'] = null;
        }

        if($UNIT05UnitsContent->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT05UnitsContent  $UNIT05UnitsContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT05UnitsContent $UNIT05UnitsContent)
    {
        storageDelete($UNIT05UnitsContent, 'path_image');

        if($UNIT05UnitsContent->delete()){
            Session::flash('success', 'Conteúdo deletado com sucessso');
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

        $UNIT05UnitsContents = UNIT05UnitsContent::whereIn('id', $request->deleteAll)->get();
        foreach($UNIT05UnitsContents as $UNIT05UnitsContent){
            storageDelete($UNIT05UnitsContent, 'path_image');
        }

        if($deleted = UNIT05UnitsContent::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' conteúdos deletados com sucessso']);
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
            UNIT05UnitsContent::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
