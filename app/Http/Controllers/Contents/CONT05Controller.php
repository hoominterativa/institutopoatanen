<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT05Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT05Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT05/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT05Contents::sorting()->get();
        return view('Admin.cruds.Contents.CONT05.index', [
            'contents' => $contents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT05.create', [
            'cropSetting' => getCropImage('Contents', 'CONT05')
        ]);
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
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link_button']  = isset($data['link_button']) ? getUri($data['link_button']) : null;

        if(CONT05Contents::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont05.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT05Contents  $CONT05Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT05Contents $CONT05Contents)
    {
        return view('Admin.cruds.Contents.CONT05.edit', [
            'content' => $CONT05Contents,
            'cropSetting' => getCropImage('Contents', 'CONT05')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT05Contents  $CONT05Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT05Contents $CONT05Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link_button']  = isset($data['link_button']) ? getUri($data['link_button']) : null;

        if($CONT05Contents->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT05Contents  $CONT05Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT05Contents $CONT05Contents)
    {

        if($CONT05Contents->delete()){
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

        if($deleted = CONT05Contents::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Conteúdos deletados com sucessso']);
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
            CONT05Contents::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $contents = CONT05Contents::active()->sorting()->get();

        return view('Client.pages.Contents.CONT05.section', [
            'contents' => $contents
        ]);
    }
}
