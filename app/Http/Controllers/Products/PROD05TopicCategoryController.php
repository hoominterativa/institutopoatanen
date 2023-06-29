<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Products\PROD05ProductsTopic;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Products\PROD05ProductsTopicCategory;

class PROD05TopicCategoryController extends Controller
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

        $data['active'] = $request->active?1:0;

        if(PROD05ProductsTopicCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar categoria');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD05ProductsTopicCategory  $PROD05ProductsTopicCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PROD05ProductsTopicCategory $PROD05ProductsTopicCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($PROD05ProductsTopicCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($PROD05ProductsTopicCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $data['active'] = $request->active?1:0;

        if($PROD05ProductsTopicCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD05ProductsTopicCategory  $PROD05ProductsTopicCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD05ProductsTopicCategory $PROD05ProductsTopicCategory)
    {
        if(PROD05ProductsTopic::where('category_id', $PROD05ProductsTopicCategory->id)->exists()){
            Session::flash('error', 'A categoria não pode ser deletada pois existem tópicos vinculados a ela');
            return redirect()->back();
        }

        storageDelete($PROD05ProductsTopicCategory, 'path_image_icon');

        if($PROD05ProductsTopicCategory->delete()){
            Session::flash('success', 'Categoria deletado com sucessso');
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
        $PROD05ProductsTopicCategorys = PROD05ProductsTopicCategory::whereIn('id', $request->deleteAll)->get();
        foreach($PROD05ProductsTopicCategorys as $PROD05ProductsTopicCategory){

            if(PROD05ProductsTopic::where('category_id', $PROD05ProductsTopicCategory->id)->exists()){
                Session::flash('error', 'A categoria não pode ser deletada pois existem tópicos vinculados a ela');
                return redirect()->back();
            }

            storageDelete($PROD05ProductsTopicCategory, 'path_image_icon');
        }

        if($deleted = PROD05ProductsTopicCategory::whereIn('id', $request->deleteAll)->delete()){
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
            PROD05ProductsTopicCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
