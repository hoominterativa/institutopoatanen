<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT07Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT01Contents;
use App\Models\Contents\CONT07ContentsSection;

class CONT07Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT07/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT07Contents::sorting()->paginate(10);
        $section = CONT07ContentsSection::first();
        return view('Admin.cruds.Contents.CONT07.index', [
            'contents' => $contents,
            'section' => $section,
            'cropSetting' => getCropImage('Contents', 'CONT07')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT07.create', [
            'cropSetting' => getCropImage('Contents', 'CONT07')
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image) $data['path_image'] = $path_image;

        if(CONT07Contents::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont07.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT07Contents  $CONT07Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT07Contents $CONT07Contents)
    {
        return view('Admin.cruds.Contents.CONT07.edit', [
            'content' => $CONT07Contents,
            'cropSetting' => getCropImage('Contents', 'CONT07')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT07Contents  $CONT07Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT07Contents $CONT07Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image){
            storageDelete($CONT07Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($CONT07Contents, 'path_image');
            $data['path_image'] = null;
        }

        if($CONT07Contents->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
            return redirect()->route('admin.cont07.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT07Contents  $CONT07Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT07Contents $CONT07Contents)
    {
        storageDelete($CONT07Contents, 'path_image');

        if($CONT07Contents->delete()){
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

        $CONT07Contentss = CONT07Contents::whereIn('id', $request->deleteAll)->get();
        foreach($CONT07Contentss as $CONT07Contents){
            storageDelete($CONT07Contents, 'path_image');
        }

        if($deleted = CONT07Contents::whereIn('id', $request->deleteAll)->delete()){
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
            CONT07Contents::where('id', $id)->update(['sorting' => $sorting]);
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
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $section = CONT07ContentsSection::active()->first();
                if($section) $section->path_image_desktop = $section->path_image_mobile;
                break;
            default:
                $section = CONT07ContentsSection::active()->first();
                break;
        }

        $contents = CONT07Contents::active()->sorting()->get();
        $video = CONT07Contents::active()->first();
        return view('Client.pages.Contents.CONT07.section', [
            'contents' => $contents,
            'section' => $section,
            'video' => $video
        ]);
    }
}
