<?php

namespace App\Http\Controllers\Products;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products\PROD05Products;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Products\PROD05ProductsSubcategory;
use App\Http\Controllers\IncludeSectionsController;

class PROD05SubcategoryController extends Controller
{
    protected $path = 'uploads/Products/PROD05/images/';

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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $data['slug'] = Str::slug($request->title);
        $data['active'] = $request->active?1:0;

        if(PROD05ProductsSubcategory::create($data)){
            Session::flash('success', 'Subcategoria cadastrada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar subcategoria');
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD05ProductsSubcategory  $PROD05ProductsSubcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PROD05ProductsSubcategory $PROD05ProductsSubcategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($PROD05ProductsSubcategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($PROD05ProductsSubcategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $data['slug'] = Str::slug($request->title);
        $data['active'] = $request->active?1:0;

        if($PROD05ProductsSubcategory->fill($data)->save()){
            Session::flash('success', 'Sucategoria atualizada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar subcategoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD05ProductsSubcategory  $PROD05ProductsSubcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD05ProductsSubcategory $PROD05ProductsSubcategory)
    {
        if(PROD05Products::where('subcategory_id', $PROD05ProductsSubcategory->id)->exists()){
            Session::flash('error', 'A subcategoria não pode ser deletada pois existem produtos vinculados a ela');
            return redirect()->back();
        }

        storageDelete($PROD05ProductsSubcategory, 'path_image_icon');

        if($PROD05ProductsSubcategory->delete()){
            Session::flash('success', 'Subcategoria deletado com sucessso');
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
        $PROD05ProductsSubcategorys = PROD05ProductsSubcategory::whereIn('id', $request->deleteAll)->get();
        foreach($PROD05ProductsSubcategorys as $PROD05ProductsSubcategory){
            if(PROD05Products::where('subcategory_id', $PROD05ProductsSubcategory->id)->exists()){
                Session::flash('error', 'A subcategoria não pode ser deletada pois existem produtos vinculados a ela');
                return redirect()->back();
            }
            storageDelete($PROD05ProductsSubcategory, 'path_image_icon');
        }

        if($deleted = PROD05ProductsSubcategory::whereIn('id', $request->deleteAll)->delete()){
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
            PROD05ProductsSubcategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
