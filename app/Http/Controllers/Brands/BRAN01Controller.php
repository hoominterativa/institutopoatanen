<?php

namespace App\Http\Controllers\Brands;

use Illuminate\Http\Request;
use App\Models\Brands\BRAN01Brands;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Brands\BRAN01BrandsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class BRAN01Controller extends Controller
{
    protected $path = 'uploads/Brands/BRAN01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = BRAN01Brands::sorting()->paginate();
        $section = BRAN01BrandsSection::first();
        return view('Admin.cruds.Brands.BRAN01.index', [
            'brands' => $brands,
            'section' => $section,
            'cropSetting' => getCropImage('Brands', 'BRAN01')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Brands.BRAN01.create', [
            'cropSetting' => getCropImage('Brands', 'BRAN01')
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
        $data['featured'] = $request->featured ? 1 : 0;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(BRAN01Brands::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.bran01.index');
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brands\BRAN01Brands  $BRAN01Brands
     * @return \Illuminate\Http\Response
     */
    public function edit(BRAN01Brands $BRAN01Brands)
    {
        return view('Admin.cruds.Brands.BRAN01.edit', [
            'brand' => $BRAN01Brands,
            'cropSetting' => getCropImage('Brands', 'BRAN01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brands\BRAN01Brands  $BRAN01Brands
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BRAN01Brands $BRAN01Brands)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($BRAN01Brands, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($BRAN01Brands, 'path_image_box');
            $data['path_image_box'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($BRAN01Brands, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($BRAN01Brands, 'path_image_icon');
            $data['path_image_icon'] = null;
        }


        if($BRAN01Brands->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.bran01.index');
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brands\BRAN01Brands  $BRAN01Brands
     * @return \Illuminate\Http\Response
     */
    public function destroy(BRAN01Brands $BRAN01Brands)
    {
        storageDelete($BRAN01Brands, 'path_image_box');
        storageDelete($BRAN01Brands, 'path_image_icon');

        if($BRAN01Brands->delete()){
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

        $BRAN01Brandss = BRAN01Brands::whereIn('id', $request->deleteAll)->get();
        foreach($BRAN01Brandss as $BRAN01Brands){
            storageDelete($BRAN01Brands, 'path_image_box');
            storageDelete($BRAN01Brands, 'path_image_icon');
        }

        if($deleted = BRAN01Brands::whereIn('id', $request->deleteAll)->delete()){
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
            BRAN01Brands::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $section = BRAN01BrandsSection::first();
                $section->path_image_banner_desktop = $section->path_image_banner_mobile;
                $section->path_image_section_desktop = $section->path_image_section_mobile;
                $section->path_image_home_desktop = $section->path_image_home_mobile;
            break;
            default:
            $section = BRAN01BrandsSection::first();
            break;
        }

        $brands = BRAN01Brands::active()->sorting()->get();

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Brands', 'BRAN01');

        return view('Client.pages.Brands.BRAN01.page',[
            'sections' => $sections,
            'brands' => $brands,
            'section' => $section
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $section = BRAN01BrandsSection::first();                
                $section->path_image_section_desktop = $section->path_image_section_mobile;
            break;
            default:
            $section = BRAN01BrandsSection::first();
            break;
        }

        $brands = BRAN01Brands::active()->sorting()->get();
        return view('Client.pages.Brands.BRAN01.section', [
            'section' => $section,
            'brands' => $brands,
        ]);
    }
}
