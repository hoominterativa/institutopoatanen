<?php

namespace App\Http\Controllers\Products;

use App\Models\Products\PROD05ProductsGalleryType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PROD05GalleryTypeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;

        if(PROD05ProductsGalleryType::create($data)){
            Session::flash('success', 'Cor cadastrada com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar cor');
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD05ProductsGalleryType  $PROD05ProductsGalleryType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PROD05ProductsGalleryType $PROD05ProductsGalleryType)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;

        if($PROD05ProductsGalleryType->fill($data)->save()){
            Session::flash('success', 'Cor atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar cor');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD05ProductsGalleryType  $PROD05ProductsGalleryType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD05ProductsGalleryType $PROD05ProductsGalleryType)
    {
        if($PROD05ProductsGalleryType->delete()){
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
        if($deleted = PROD05ProductsGalleryType::whereIn('id', $request->deleteAll)->delete()){
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
            PROD05ProductsGalleryType::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
