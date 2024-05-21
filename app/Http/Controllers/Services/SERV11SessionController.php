<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV11ServicesSession;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV11SessionController extends Controller
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

        if($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title. ' ' . ($request->subtitle ?? ''));

        if(SERV11ServicesSession::create($data)){
            Session::flash('success', 'Sessão cadastrada com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar a sessão');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV11ServicesSession  $SERV11ServicesSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV11ServicesSession $SERV11ServicesSession)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title. ' ' . ($request->subtitle ?? ''));

        if($SERV11ServicesSession->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a sessão');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV11ServicesSession  $SERV11ServicesSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV11ServicesSession $SERV11ServicesSession)
    {

        if($SERV11ServicesSession->delete()){
            Session::flash('success', 'Sessão deletada com sucessso');
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

        if($deleted = SERV11ServicesSession::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' sessões deletadas com sucessso']);
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
            SERV11ServicesSession::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
