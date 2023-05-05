<?php

namespace App\Http\Controllers\Galleries;

use App\Models\Galleries\GALL02Galleries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Galleries\GALL01Galleries;
use App\Models\Galleries\GALL02GalleriesSection;

class GALL02Controller extends Controller
{
    protected $path = 'uploads/Galleries/GALL02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = GALL02Galleries::sorting()->paginate(20);
        $section = GALL02GalleriesSection::first();
        return view('Admin.cruds.Galleries.GALL02.index', [
            'galleries' => $galleries,
            'section' => $section,
            'cropSetting' => getCropImage('Galleries', 'GALL02')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Galleries.GALL02.create', [
            'cropSetting' => getCropImage('Galleries', 'GALL02')
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(GALL02Galleries::create($data)){
            Session::flash('success', 'Imagem cadastrada com sucesso');
            return redirect()->route('admin.gall02.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar a imagem');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galleries\GALL02Galleries  $GALL02Galleries
     * @return \Illuminate\Http\Response
     */
    public function edit(GALL02Galleries $GALL02Galleries)
    {
        return view('Admin.cruds.Galleries.GALL02.edit', [
            'gallery' => $GALL02Galleries,
            'cropSetting' => getCropImage('Galleries', 'GALL02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galleries\GALL02Galleries  $GALL02Galleries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GALL02Galleries $GALL02Galleries)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($GALL02Galleries, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($GALL02Galleries, 'path_image');
            $data['path_image'] = null;
        }

        if($GALL02Galleries->fill($data)->save()){
            Session::flash('success', 'Imagem atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a imagem');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galleries\GALL02Galleries  $GALL02Galleries
     * @return \Illuminate\Http\Response
     */
    public function destroy(GALL02Galleries $GALL02Galleries)
    {
        storageDelete($GALL02Galleries, 'path_image');

        if($GALL02Galleries->delete()){
            Session::flash('success', 'Imagem deletada com sucessso');
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

        $GALL02Galleriess = GALL02Galleries::whereIn('id', $request->deleteAll)->get();
        foreach($GALL02Galleriess as $GALL02Galleries){
            storageDelete($GALL02Galleries, 'path_image');
        }

        if($deleted = GALL02Galleries::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Imagens deletadas com sucessso']);
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
            GALL02Galleries::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Galleries\GALL02Galleries  $GALL02Galleries
     * @return \Illuminate\Http\Response
     */
    //public function show(GALL02Galleries $GALL02Galleries)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Galleries', 'GALL02', 'show');

        return view('Client.pages.Galleries.GALL02.show',[
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
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $section = GALL02GalleriesSection::active()->first();
                if($section) $section->path_image_desktop = $section->path_image_mobile;
                break;
            default:
                $section = GALL02GalleriesSection::active()->first();
                break;
        }

        $galleries = GALL02Galleries::active()->sorting()->get();
        return view('Client.pages.Galleries.GALL02.section', [
            'section' => $section,
            'galleries' => $galleries
        ]);
    }
}
