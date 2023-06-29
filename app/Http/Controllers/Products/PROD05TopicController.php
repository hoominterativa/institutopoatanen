<?php

namespace App\Http\Controllers\Products;

use App\Models\Products\PROD05ProductsTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PROD05TopicController extends Controller
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

        if(PROD05ProductsTopic::create($data)){
            Session::flash('success', 'Informaçoes cadastradas com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD05ProductsTopic  $PROD05ProductsTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PROD05ProductsTopic $PROD05ProductsTopic)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;

        if($PROD05ProductsTopic->fill($data)->save()){
            Session::flash('success', 'Informações atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD05ProductsTopic  $PROD05ProductsTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD05ProductsTopic $PROD05ProductsTopic)
    {
        if($PROD05ProductsTopic->delete()){
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
        if($deleted = PROD05ProductsTopic::whereIn('id', $request->deleteAll)->delete()){
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
            PROD05ProductsTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
