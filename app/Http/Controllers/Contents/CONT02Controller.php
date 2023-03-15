<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT02Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT02Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT02Contents::active()->sorting()->get();

        return view('Admin.cruds.Contents.CONT02.index', [
            'contents' => $contents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT02.create',[
            'cropSetting' => getCropImage('Contents', 'CONT02')
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
        $data['link_button'] = getUri($request->link_button);

        $path_image_background_desktop = $helper->optimizeImage($request, 'path_image_background_desktop', $this->path, null,100);
        if($path_image_background_desktop) $data['path_image_background_desktop'] = $path_image_background_desktop;

        $path_image_background_mobile = $helper->optimizeImage($request, 'path_image_background_mobile', $this->path, null,100);
        if($path_image_background_mobile) $data['path_image_background_mobile'] = $path_image_background_mobile;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(CONT02Contents::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont02.index');
        }else{
            Storage::delete($path_image_background_desktop);
            Storage::delete($path_image_background_mobile);
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT02Contents  $CONT02Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT02Contents $CONT02Contents)
    {
        $CONT02Contents->link_button = getUri($CONT02Contents->link_button);
        return view('Admin.cruds.Contents.CONT02.edit', [
            'content' => $CONT02Contents,
            'cropSetting' => getCropImage('Contents', 'CONT02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT02Contents  $CONT02Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT02Contents $CONT02Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link_button'] = getUri($request->link_button);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($CONT02Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($CONT02Contents, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_background_desktop = $helper->optimizeImage($request, 'path_image_background_desktop', $this->path, null,100);
        if($path_image_background_desktop){
            storageDelete($CONT02Contents, 'path_image_background_desktop');
            $data['path_image_background_desktop'] = $path_image_background_desktop;
        }
        if($request->delete_path_image_background_desktop && !$path_image_background_desktop){
            storageDelete($CONT02Contents, 'path_image_background_desktop');
            $data['path_image_background_desktop'] = null;
        }

        $path_image_background_mobile = $helper->optimizeImage($request, 'path_image_background_mobile', $this->path, null,100);
        if($path_image_background_mobile){
            storageDelete($CONT02Contents, 'path_image_background_mobile');
            $data['path_image_background_mobile'] = $path_image_background_mobile;
        }
        if($request->delete_path_image_background_mobile && !$path_image_background_mobile){
            storageDelete($CONT02Contents, 'path_image_background_mobile');
            $data['path_image_background_mobile'] = null;
        }

        if($CONT02Contents->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
            return redirect()->route('admin.cont02.index');
        }else{
            Storage::delete($path_image_background_desktop);
            Storage::delete($path_image_background_mobile);
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT02Contents  $CONT02Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT02Contents $CONT02Contents)
    {
        storageDelete($CONT02Contents, 'path_image_background_desktop');
        storageDelete($CONT02Contents, 'path_image_background_mobile');
        storageDelete($CONT02Contents, 'path_image');

        if($CONT02Contents->delete()){
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
        

        $CONT02Contentss = CONT02Contents::whereIn('id', $request->deleteAll)->get();
        foreach($CONT02Contentss as $CONT02Contents){
            storageDelete($CONT02Contents, 'path_image_background_desktop');
            storageDelete($CONT02Contents, 'path_image_background_mobile');
            storageDelete($CONT02Contents, 'path_image');
        }
        

        if($deleted = CONT02Contents::whereIn('id', $request->deleteAll)->delete()){
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
            CONT02Contents::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $contents = CONT02Contents::active()->sorting()->get();
        return view('Client.pages.Contents.CONT02.section', [
            'contents' => $contents
        ]);
    }
}
