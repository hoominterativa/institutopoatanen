<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT13Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT13ContentsGallery;
use App\Models\Contents\CONT13ContentsSection;
use App\Models\Contents\CONT13ContentsTopic;

class CONT13Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT13/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT13Contents::sorting()->get();
        $section = CONT13ContentsSection::first();
        $topics = CONT13ContentsTopic::sorting()->get();
        return view('Admin.cruds.Contents.CONT13.index', [
            'contents' => $contents,
            'section' => $section,
            'topics' => $topics,
            'cropSetting' => getCropImage('Contents', 'CONT13')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT13.create', [
            'cropSetting' => getCropImage('Contents', 'CONT13')
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

        $data['active'] = $request->active ? 1 : 0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if($content = CONT13Contents::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont13.edit',[ 'CONT13Contents' => $content->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT13Contents  $CONT13Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT13Contents $CONT13Contents)
    {
        $galleries = CONT13ContentsGallery::where('content_id', $CONT13Contents->id)->sorting()->get();
        return view('Admin.cruds.Contents.CONT13.edit',[
            'content' => $CONT13Contents,
            'galleries' => $galleries,
            'cropSetting' => getCropImage('Contents', 'CONT13')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT13Contents  $CONT13Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT13Contents $CONT13Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($CONT13Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($CONT13Contents, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($CONT13Contents, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($CONT13Contents, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($CONT13Contents, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($CONT13Contents, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }


        if($CONT13Contents->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT13Contents  $CONT13Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT13Contents $CONT13Contents)
    {
        $galleries = CONT13ContentsGallery::where('content_id', $CONT13Contents->id)->get();
        if ($galleries->count()) {
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }
        }

        storageDelete($CONT13Contents, 'path_image');
        storageDelete($CONT13Contents, 'path_image_desktop');
        storageDelete($CONT13Contents, 'path_image_mobile');

        if($CONT13Contents->delete()){
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

        $CONT13Contentss = CONT13Contents::whereIn('id', $request->deleteAll)->get();
        foreach($CONT13Contentss as $CONT13Contents){
            $galleries = CONT13ContentsGallery::where('content_id', $CONT13Contents->id);
            if ($galleries->count()) {
                foreach ($galleries as $gallery) {
                    storageDelete($gallery, 'path_image');
                    $gallery->delete();
                }
            }

            storageDelete($CONT13Contents, 'path_image');
            storageDelete($CONT13Contents, 'path_image_desktop');
            storageDelete($CONT13Contents, 'path_image_mobile');
        }

        if($deleted = CONT13Contents::whereIn('id', $request->deleteAll)->delete()){
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
            CONT13Contents::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Contents\CONT13Contents  $CONT13Contents
     * @return \Illuminate\Http\Response
     */
    //public function show(CONT13Contents $CONT13Contents)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contents', 'CONT13', 'show');

        return view('Client.pages.Contents.CONT13.show',[
            'sections' => $sections
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $section = CONT13ContentsSection::first();
        $contents = CONT13Contents::with('galleries')->active()->sorting()->get();
        $topics = CONT13ContentsTopic::active()->sorting()->get();

        switch(deviceDetect()){
            case 'mobile':
            case 'tablet':
                if($section) {
                    $section->path_image_desktop = $section->path_image_mobile;
                }
                if($contents->count()) {
                    foreach($contents as $content){
                        $content->path_image_desktop = $content->path_image_mobile;
                    }
                }
            break;
        }
        return view('Client.pages.Contents.CONT13.section',[
            'section' => $section,
            'contents' => $contents,
            'topics' => $topics
        ]);
    }
}
