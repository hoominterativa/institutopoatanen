<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV09ServicesCity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV09CityController extends Controller
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

        $data['active']= $request->active ? 1 : 0;

        if(SERV09ServicesCity::create($data)){
            Session::flash('success', 'Cidade cadastrada com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar a cidade');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV09ServicesCity  $SERV09ServicesCity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV09ServicesCity $SERV09ServicesCity)
    {
        $data = $request->all();

        $data['active']= $request->active ? 1 : 0;

        if($SERV09ServicesCity->fill($data)->save()){
            Session::flash('success', 'Cidade atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a cidade');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV09ServicesCity  $SERV09ServicesCity
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV09ServicesCity $SERV09ServicesCity)
    {

        if($SERV09ServicesCity->delete()){
            Session::flash('success', 'Cidade deletada com sucessso');
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

        if($deleted = SERV09ServicesCity::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' cidades deletadas com sucessso']);
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
            SERV09ServicesCity::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
