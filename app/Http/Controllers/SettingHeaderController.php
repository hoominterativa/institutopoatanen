<?php

namespace App\Http\Controllers;

use App\Models\SettingHeader;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SettingHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = SettingHeader::sorting()->get();
        return view('Admin.cruds.settingHeader.index',[
            'headers' => $headers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.settingHeader.create');
    }

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
        $data['exists'] = $request->exists?1:0;
        if($request->limit=='all'){
            $data['limit'] = null;
        }

        if($request->pageN){
            $data['page'] = $request->pageN;
        }

        if($data['select_dropdown']=='' && $data['link']<>''){
            $data['select_dropdown'] = NULL;
            $data['condition'] = NULL;
            $data['exists'] = NULL;
            $data['limit'] = NULL;
        }

        if(SettingHeader::create($data)){
            Session::flash('success', 'Link do menu cadastrado com sucesso');
            return redirect()->route('admin.header.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar link');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SettingHeader  $SettingHeader
     * @return \Illuminate\Http\Response
     */
    public function edit(SettingHeader $SettingHeader)
    {
        if(!$SettingHeader->limit){
            $SettingHeader->limit = 'all';
        }
        return view('Admin.cruds.settingHeader.edit',[
            'header' => $SettingHeader
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SettingHeader  $SettingHeader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingHeader $SettingHeader)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;
        $data['exists'] = $request->exists?1:0;

        if($request->limit=='all'){
            $data['limit'] = null;
        }

        if($request->pageN){
            $data['page'] = $request->pageN;
        }

        if($data['select_dropdown']=='' && $data['link']<>''){
            $data['select_dropdown'] = NULL;
            $data['condition'] = NULL;
            $data['exists'] = NULL;
            $data['limit'] = NULL;
        }

        if($SettingHeader->fill($data)->save()){
            Session::flash('success', 'Link do menu atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar link');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SettingHeader  $SettingHeader
     * @return \Illuminate\Http\Response
     */
    public function destroy(SettingHeader $SettingHeader)
    {
        if($SettingHeader->delete()){
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
        if($deleted = SettingHeader::whereIn('id', $request->deleteAll)->delete()){
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
            SettingHeader::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    public function listRelations(Request $request)
    {
        $pages = getRelationsModel($request->module, $request->model, $request->page);
        if(!$pages) return Response::json(['dropdown' => 'false']);

        return view('Admin.components.models.dropdownRelations',[
            'pages' => $pages,
            'module' => $request->module,
            'code' => $request->model,
            'page' => $request->page,
            'type' => 'relations'
        ])->render();

    }

    public function listConditions(Request $request)
    {
        if($request->has('relation')){
            $relations = getCondition($request->module, $request->model, null, $request->relation);
        }else{
            $relations = getCondition($request->module, $request->model);
        }
        if(!$relations) return Response::json(['dropdown' => 'false']);

        return view('Admin.components.models.dropdownRelations',[
            'relations' => $relations,
            'type' => 'conditions'
        ])->render();
    }
}
