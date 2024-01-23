<?php

namespace App\Http\Controllers\Contents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contents\CONT14Contents;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Contents\CONT14ContentsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Contents\CONT14ContentsCategory;
use App\Http\Controllers\IncludeSectionsController;

class CONT14Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT14/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT14Contents::sorting()->get();
        $categories = CONT14ContentsCategory::sorting()->get();
        $section = CONT14ContentsSection::first();
        return view('Admin.cruds.Contents.CONT14.index', [
            'contents' => $contents,
            'categories' => $categories,
            'section' => $section,
            'cropSetting' => getCropImage('Contents', 'CONT14')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CONT14ContentsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Contents.CONT14.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Contents', 'CONT14')
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

        if(CONT14Contents::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont14.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT14Contents  $CONT14Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT14Contents $CONT14Contents)
    {
        $categories = CONT14ContentsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Contents.CONT14.edit', [
            'categories' => $categories,
            'content' => $CONT14Contents,
            'cropSetting' => getCropImage('Contents', 'CONT14')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT14Contents  $CONT14Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT14Contents $CONT14Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($CONT14Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($CONT14Contents, 'path_image');
            $data['path_image'] = null;
        }

        if($CONT14Contents->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT14Contents  $CONT14Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT14Contents $CONT14Contents)
    {
        storageDelete($CONT14Contents, 'path_image');

        if($CONT14Contents->delete()){
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

        $CONT14Contentss = CONT14Contents::whereIn('id', $request->deleteAll)->get();
        foreach($CONT14Contentss as $CONT14Contents){
            storageDelete($CONT14Contents, 'path_image');
        }

        if($deleted = CONT14Contents::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' conteúdos deletados com sucessso']);
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
            CONT14Contents::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Contents\CONT14Contents  $CONT14Contents
     * @return \Illuminate\Http\Response
     */
    //public function show(CONT14Contents $CONT14Contents)
    public function show(CONT14ContentsCategory $CONT14ContentsCategory, CONT14Contents $CONT14Contents)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contents', 'CONT14', 'show');

        $contents = $CONT14Contents->where('category_id', $CONT14ContentsCategory->id)->active()->sorting()->get();

        return view('Client.pages.Contents.CONT14.show',[
            'sections' => $sections,
            'contents' => $contents
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $categories = CONT14ContentsCategory::exists()->active()->sorting()->get();

        $categoryFirst = CONT14ContentsCategory::exists()->active()->first();
        $contents = CONT14Contents::where('category_id', $categoryFirst->id)->active()->sorting()->get();

        $section = CONT14ContentsSection::active()->first();

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($section) $section->path_image_desktop = $section->path_image_mobile;
            break;
        }


        return view('Client.pages.Contents.CONT14.section',[
            'section' => $section,
            'categories' => $categories,
            'contents' => $contents,
            'categoryFirst' => $categoryFirst
        ]);
    }
}
