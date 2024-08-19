<?php

namespace App\Http\Controllers\Brands;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Brands\BRAN02BrandsMarcas;
use App\Models\Brands\BRAN02BrandsCategories;

class BRAN02MarcasController extends Controller
{
    protected $path = 'uploads/Brands/BRAN02/images/';


    public function create()
    
    {
        $categories = BRAN02BrandsCategories::active()->sorting()->pluck('category', 'id');

        $sections = BRAN02BrandsCategories::active()->sorting()->get();
        return view('Admin.cruds.Brands.BRAN02.marcas.create', [
            'cropSetting' => getCropImage('Brands', 'BRAN02'),
            'sections' => $sections,
            'categories' => $categories
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

        $data['active'] = $request->active ? 1 : 0;
        $data['highlighted'] = $request->highlighted ? 1 : 0;

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);

        if($path_image) $data['path_image'] = $path_image;


        if(BRAN02BrandsMarcas::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.bran02.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     */
    public function edit(BRAN02BrandsMarcas $BRAN02BrandsMarcas)
    {

        $categories = BRAN02BrandsCategories::active()->sorting()->pluck('category', 'id');
        
        return view('Admin.cruds.Brands.BRAN02.marcas.edit', [
            'cropSetting' => getCropImage('Brands', 'BRAN02'),
            'BrandsMarcas' => $BRAN02BrandsMarcas,
            'categories' => $categories,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BRAN02BrandsMarcas $BRAN02BrandsMarcas)
    {
        
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        $data['highlighted'] = $request->highlighted ? 1 : 0;

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($BRAN02BrandsMarcas, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($BRAN02BrandsMarcas, 'path_image');
            $data['path_image'] = null;
        }




        if($BRAN02BrandsMarcas->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.bran02.index');
        }else{
            //Storage::delete($path_image);
            //Storage::delete($path_archive);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     */
    public function destroy(BRAN02BrandsMarcas $BRAN02BrandsMarcas)
    {
        storageDelete($BRAN02BrandsMarcas, 'path_image');


        if($BRAN02BrandsMarcas->delete()){
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


        $BRAN02BrandsMarcas = BRAN02BrandsMarcas::whereIn('id', $request->deleteAll)->get();
        foreach($BRAN02BrandsMarcas as $BRAN02Brands){
            storageDelete($BRAN02Brands, 'path_image');
        }
        
                        
        if($deleted = BRAN02BrandsMarcas::whereIn('id', $request->deleteAll)->delete()){                  
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
            BRAN02BrandsMarcas::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    public function options($categories){

        $options = [];

        foreach ($categories as $category) {
            $options[$category['id']] = $category['category'];
        }

        return $options;
    }
}