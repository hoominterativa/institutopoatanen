<?php

namespace App\Http\Controllers\Units;

use App\Models\Units\UNIT05UnitsLink;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT05LinkController extends Controller
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

        if(UNIT05UnitsLink::create($data)){
            Session::flash('success', 'Link cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar o link');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT05UnitsLink  $UNIT05UnitsLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT05UnitsLink $UNIT05UnitsLink)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        if($UNIT05UnitsLink->fill($data)->save()){
            Session::flash('success', 'Link atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar o link');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT05UnitsLink  $UNIT05UnitsLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT05UnitsLink $UNIT05UnitsLink)
    {

        if($UNIT05UnitsLink->delete()){
            Session::flash('success', 'Link deletado com sucessso');
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
        if($deleted = UNIT05UnitsLink::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' links deletados com sucessso']);
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
            UNIT05UnitsLink::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
