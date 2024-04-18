<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV09ServicesState;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV09StateController extends Controller
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

        $data['active'] = $request->active ? 1 : 0;

        if ($request->acronym) $data['acronym'] = strtoupper($request->acronym);

        if(SERV09ServicesState::create($data)){
            Session::flash('success', 'Estado cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar o estado');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV09ServicesState  $SERV09ServicesState
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV09ServicesState $SERV09ServicesState)
    {
        $data = $request->all();

        $data['active']= $request->active ? 1 : 0;

        if ($request->acronym) $data['acronym'] = strtoupper($request->acronym);

        if($SERV09ServicesState->fill($data)->save()){
            Session::flash('success', 'Estado atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar o estado');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV09ServicesState  $SERV09ServicesState
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV09ServicesState $SERV09ServicesState)
    {

        if($SERV09ServicesState->delete()){
            Session::flash('success', 'estado deletado com sucessso');
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


        if($deleted = SERV09ServicesState::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Estados deletados com sucessso']);
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
            SERV09ServicesState::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
