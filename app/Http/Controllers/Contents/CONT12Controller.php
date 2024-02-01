<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT12Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT12ContentsSection;
use App\Models\Contents\CONT12ContentsTopic;

class CONT12Controller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT12Contents::sorting()->get();
        return view('Admin.cruds.Contents.CONT12.index',[
            'contents' => $contents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT12.create');
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

        $data['active'] = $request->active? 1 : 0;

        if ($content = CONT12Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont12.edit', ['CONT12Contents' => $content->id]);
        } else {
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT12Contents  $CONT12Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT12Contents $CONT12Contents)
    {
        $topics = CONT12ContentsTopic::where('content_id', $CONT12Contents->id)->sorting()->get();
        
        return view('Admin.cruds.Contents.CONT12.edit',[
            'content' => $CONT12Contents,
            'topics' => $topics,
            'cropSetting' => getCropImage('Contents', 'CONT12')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT12Contents  $CONT12Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT12Contents $CONT12Contents)
    {
        $data = $request->all();

        $data['active'] = $request->active? 1 : 0;

        if ($CONT12Contents->fill($data)->save()) {
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        } else {
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT12Contents  $CONT12Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT12Contents $CONT12Contents)
    {

        if ($CONT12Contents->delete()) {
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

        if ($deleted = CONT12Contents::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' Conteúdos deletados com sucessso']);
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
        foreach ($request->arrId as $sorting => $id) {
            CONT12Contents::where('id', $id)->update(['sorting' => $sorting]);
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
        $contents = CONT12Contents::with('topics')->active()->sorting()->get();
        return view('Client.pages.Contents.CONT12.section',[
            'contents' => $contents,
        ]);
    }
}
