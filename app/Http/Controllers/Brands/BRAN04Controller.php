<?php

namespace App\Http\Controllers\Brands;

use App\Models\Brands\BRAN04Brands;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Brands\BRAN04BrandsSection;

class BRAN04Controller extends Controller
{
    protected $path = 'uploads/Brands/BRAN04/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = BRAN04Brands::sorting()->paginate(32);
        $section = BRAN04BrandsSection::first();
        return view('Admin.cruds.Brands.BRAN04.index',[
            'brands' => $brands,
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
        return view('Admin.cruds.Brands.BRAN04.create',[
            'cropSetting' => getCropImage('Brands', 'BRAN04')
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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(BRAN04Brands::create($data)){
            Session::flash('success', 'Marca cadastrada com sucesso');
            return redirect()->route('admin.bran04.index');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar a marca');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brands\BRAN04Brands  $BRAN04Brands
     * @return \Illuminate\Http\Response
     */
    public function edit(BRAN04Brands $BRAN04Brands)
    {
        return view('Admin.cruds.Brands.BRAN04.edit',[
            'brand' => $BRAN04Brands,
            'cropSetting' => getCropImage('Brands', 'BRAN04')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brands\BRAN04Brands  $BRAN04Brands
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BRAN04Brands $BRAN04Brands)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($BRAN04Brands, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($BRAN04Brands, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($BRAN04Brands, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($BRAN04Brands, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($BRAN04Brands->fill($data)->save()){
            Session::flash('success', 'Marca atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar a marca');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brands\BRAN04Brands  $BRAN04Brands
     * @return \Illuminate\Http\Response
     */
    public function destroy(BRAN04Brands $BRAN04Brands)
    {
        storageDelete($BRAN04Brands, 'path_image');
        storageDelete($BRAN04Brands, 'path_image_icon');

        if($BRAN04Brands->delete()){
            Session::flash('success', 'Marca deletada com sucessso');
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

        $BRAN04Brandss = BRAN04Brands::whereIn('id', $request->deleteAll)->get();
        foreach($BRAN04Brandss as $BRAN04Brands){
            storageDelete($BRAN04Brands, 'path_image');
            storageDelete($BRAN04Brands, 'path_image_icon');
        }

        if($deleted = BRAN04Brands::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Marcas deletados com sucessso']);
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
            BRAN04Brands::where('id', $id)->update(['sorting' => $sorting]);
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
        $brands = BRAN04Brands::active()->sorting()->get();
        $section = BRAN04BrandsSection::active()->first();

        return view('Client.pages.Brands.BRAN04.section',[
            'section' => $section,
            'brands' => $brands
        ]);
    }
}
