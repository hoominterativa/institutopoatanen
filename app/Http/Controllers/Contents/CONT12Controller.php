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

class CONT12Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT12/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT12Contents::sorting()->get();
        $section = CONT12ContentsSection::first();
        return view('Admin.cruds.Contents.CONT12.index',[
            'contents' => $contents,
            'section' => $section
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT12.create',[
            'cropSetting' => getCropImage('Contents', 'CONT12')
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

        $data['active'] = $request->active? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive) $data['path_archive'] = $path_archive;

        if (CONT12Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont12.index');
        } else {
            Storage::delete($path_image_icon);
            Storage::delete($path_archive);
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
        return view('Admin.cruds.Contents.CONT12.edit',[
            'content' => $CONT12Contents,
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
        $helper = new HelperArchive();

        $data['active'] = $request->active? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($CONT12Contents, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($CONT12Contents, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive){
            storageDelete($CONT12Contents, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($CONT12Contents, 'path_archive');
            $data['path_archive'] = null;
        }

        if ($CONT12Contents->fill($data)->save()) {
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        } else {
            Storage::delete($path_image_icon);
            Storage::delete($path_archive);
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
        storageDelete($CONT12Contents, 'path_image_icon');
        storageDelete($CONT12Contents, 'path_archive');

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

        $CONT12Contentss = CONT12Contents::whereIn('id', $request->deleteAll)->get();
        foreach($CONT12Contentss as $CONT12Contents){
            storageDelete($CONT12Contents, 'path_image_icon');
            storageDelete($CONT12Contents, 'path_archive');
        }

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
        $contents = CONT12Contents::active()->sorting()->get();
        $section = CONT12ContentsSection::active()->first();
        return view('Client.pages.Contents.CONT12.section',[
            'contents' => $contents,
            'section' => $section
        ]);
    }
}
