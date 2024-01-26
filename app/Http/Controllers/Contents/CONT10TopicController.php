<?php

namespace App\Http\Controllers\Contents;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Contents\CONT10ContentsTopic;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT10TopicController extends Controller
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
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $data['date'] = isset($data['date']) ? Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d') : null;

        if(CONT10ContentsTopic::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar o item');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT10ContentsTopic  $CONT10ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT10ContentsTopic $CONT10ContentsTopic)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $data['date'] = isset($data['date']) ? Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d') : null;

        if($CONT10ContentsTopic->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT10ContentsTopic  $CONT10ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT10ContentsTopic $CONT10ContentsTopic)
    {

        if($CONT10ContentsTopic->delete()){
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

        if($deleted = CONT10ContentsTopic::whereIn('id', $request->deleteAll)->delete()){
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
            CONT10ContentsTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
