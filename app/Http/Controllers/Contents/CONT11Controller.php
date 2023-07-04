<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT11Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT11ContentsGallery;

class CONT11Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT11Contents::sorting()->get();
        return view('Admin.cruds.Contents.CONT11.index', [
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
        return view('Admin.cruds.Contents.CONT11.create');
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

        if ($content = CONT11Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont11.edit', ['CONT11Contents' => $content->id]);
        } else {
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT11Contents  $CONT11Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT11Contents $CONT11Contents)
    {
        $galleries = CONT11ContentsGallery::where('content_id', $CONT11Contents->id)->sorting()->get();
        return view('Admin.cruds.Contents.CONT11.edit', [
            'content' => $CONT11Contents,
            'galleries' => $galleries,
            'cropSetting' => getCropImage('Contents', 'CONT11'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT11Contents  $CONT11Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT11Contents $CONT11Contents)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        if ($CONT11Contents->fill($data)->save()) {
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        } else {
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT11Contents  $CONT11Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT11Contents $CONT11Contents)
    {
        $galleries = CONT11ContentsGallery::where('content_id', $CONT11Contents->id)->get();
        if ($galleries) {
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }
        }

        if ($CONT11Contents->delete()) {
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

        $CONT11Contentss = CONT11Contents::whereIn('id', $request->deleteAll)->get();
        foreach($CONT11Contentss as $CONT11Contents){
            $galleries = CONT11ContentsGallery::where('content_id', $CONT11Contents->id)->get();
            if ($galleries) {
                foreach ($galleries as $gallery) {
                    storageDelete($gallery, 'path_image');
                    $gallery->delete();
                }
            }
        }

        if ($deleted = CONT11Contents::whereIn('id', $request->deleteAll)->delete()) {
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
            CONT11Contents::where('id', $id)->update(['sorting' => $sorting]);
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
        $contents = CONT11Contents::with('galleries')->active()->sorting()->get();
        return view('Client.pages.Contents.CONT11.section',[
            'contents' => $contents
        ]);
    }
}
