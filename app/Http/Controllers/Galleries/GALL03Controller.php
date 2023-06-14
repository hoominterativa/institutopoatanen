<?php

namespace App\Http\Controllers\Galleries;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Galleries\GALL03Galleries;
use App\Models\Galleries\GALL03GalleriesImage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Galleries\GALL03GalleriesBanner;
use App\Models\Galleries\GALL03GalleriesSection;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Galleries\GALL03GalleriesSectionGallery;
use App\Http\Controllers\Galleries\GALL03SectionController;

class GALL03Controller extends Controller
{
    protected $path = 'uploads/Galleries/GALL03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = GALL03Galleries::sorting()->paginate(20);
        $section = GALL03GalleriesSection::first();
        $sectionGallery = GALL03GalleriesSectionGallery::first();
        $banner = GALL03GalleriesBanner::first();
        return view('Admin.cruds.Galleries.GALL03.index', [
            'galleries' => $galleries,
            'sectionGallery' => $sectionGallery,
            'section' => $section,
            'banner' => $banner,
            'cropSetting' => getCropImage('Galleries', 'GALL03')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Galleries.GALL03.create',[
            'cropSetting' => getCropImage('Galleries', 'GALL03')
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
        $data['featured'] = $request->featured?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if($gallery = GALL03Galleries::create($data)){
            Session::flash('success', 'Galeria cadastrada com sucesso');
            return redirect()->route('admin.gall03.edit', ['GALL03Galleries' => $gallery]);
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar a galeria');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galleries\GALL03Galleries  $GALL03Galleries
     * @return \Illuminate\Http\Response
     */
    public function edit(GALL03Galleries $GALL03Galleries)
    {
        $images = GALL03GalleriesImage::where('gallery_id', $GALL03Galleries->id)->get();
        return view('Admin.cruds.Galleries.GALL03.edit',[
            'gallery' => $GALL03Galleries,
            'images' => $images,
            'cropSetting' => getCropImage('Galleries', 'GALL03')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galleries\GALL03Galleries  $GALL03Galleries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GALL03Galleries $GALL03Galleries)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($GALL03Galleries, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($GALL03Galleries, 'path_image');
            $data['path_image'] = null;
        }

        if($GALL03Galleries->fill($data)->save()){
            Session::flash('success', 'Galeria atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a galeria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galleries\GALL03Galleries  $GALL03Galleries
     * @return \Illuminate\Http\Response
     */
    public function destroy(GALL03Galleries $GALL03Galleries)
    {
        $images = GALL03GalleriesImage::where('gallery_id', $GALL03Galleries->id)->get();
        foreach($images as $image) {
            storageDelete('image', 'path_image');
            $image->delete();
        }

        storageDelete($GALL03Galleries, 'path_image');

        if($GALL03Galleries->delete()){
            Session::flash('success', 'Galeria deletada com sucessso');
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
        $GALL03Galleriess = GALL03Galleries::whereIn('id', $request->deleteAll)->get();
        foreach($GALL03Galleriess as $GALL03Galleries){
            $images = GALL03GalleriesImage::where('gallery_id', $GALL03Galleries->id)->get();
            foreach($images as $image) {
                storageDelete('image', 'path_image');
                $image->delete();
            }

            storageDelete($GALL03Galleries, 'path_image');
        }

        if($deleted = GALL03Galleries::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Galerias deletadas com sucessso']);
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
            GALL03Galleries::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Galleries\GALL03Galleries  $GALL03Galleries
     * @return \Illuminate\Http\Response
     */
    //public function show(GALL03Galleries $GALL03Galleries)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Galleries', 'GALL03', 'show');

        return view('Client.pages.Galleries.GALL03.show',[
            'sections' => $sections
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $banner = GALL03GalleriesBanner::active()->first();
                if($banner) $banner->path_image_desktop = $banner->path_image_mobile;
                break;
            default:
                $banner = GALL03GalleriesBanner::active()->first();
                break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Galleries', 'GALL03', 'page');

        $sectionGallery = GALL03GalleriesSectionGallery::active()->first();
        $galleries = GALL03Galleries::with('images')->active()->sorting()->get();

        return view('Client.pages.Galleries.GALL03.page',[
            'banner' => $banner,
            'sectionGallery' => $sectionGallery,
            'galleries' => $galleries,
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
        $section = GALL03GalleriesSection::active()->first();
        $galleries = GALL03Galleries::with('images')->active()->sorting()->get();
        return view('Client.pages.Galleries.GALL03.section', [
            'section' => $section,
            'galleries' => $galleries
        ]);
    }
}
