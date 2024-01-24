<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT09Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT09ContentsTopic;
use App\Models\Contents\CONT09ContentsTopicSection;

class CONT09Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT09/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT09Contents::sorting()->get();
        return view('Admin.cruds.Contents.CONT09.index', [
            'contents' => $contents,
            'cropSetting' => getCropImage('Contents', 'CONT09')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT09.create', [
            'cropSetting' => getCropImage('Contents', 'CONT09')
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
        $data['active_section'] = $request->active_section?1:0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if($content = CONT09Contents::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.cont09.edit', ['CONT09Contents' => $content->id]);
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT09Contents  $CONT09Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT09Contents $CONT09Contents)
    {
        $topics = CONT09ContentsTopic::where('content_id', $CONT09Contents->id)->sorting()->get();
        return view('Admin.cruds.Contents.CONT09.edit', [
            'content' => $CONT09Contents,
            'topics' => $topics,
            'cropSetting' => getCropImage('Contents', 'CONT09')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT09Contents  $CONT09Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT09Contents $CONT09Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['active_section'] = $request->active_section?1:0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop){
            storageDelete($CONT09Contents, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($CONT09Contents, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile){
            storageDelete($CONT09Contents, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($CONT09Contents, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($CONT09Contents->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT09Contents  $CONT09Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT09Contents $CONT09Contents)
    {
        storageDelete($CONT09Contents, 'path_image_desktop');
        storageDelete($CONT09Contents, 'path_image_mobile');

        if($CONT09Contents->delete()){
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

        $CONT09Contentss = CONT09Contents::whereIn('id', $request->deleteAll)->get();
        foreach($CONT09Contentss as $CONT09Contents){
            storageDelete($CONT09Contents, 'path_image_desktop');
            storageDelete($CONT09Contents, 'path_image_mobile');
        }

        if($deleted = CONT09Contents::whereIn('id', $request->deleteAll)->delete()){
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
            CONT09Contents::where('id', $id)->update(['sorting' => $sorting]);
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
        $contents = CONT09Contents::with('topics')->active()->sorting()->get();

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                foreach($contents as $content) {
                    if($content) $content->path_image_desktop = $content->path_image_mobile;
                }
            break;
        }

        return view('Client.pages.Contents.CONT09.section', [
            'contents' => $contents,
        ]);
    }
}
