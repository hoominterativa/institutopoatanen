<?php

namespace App\Http\Controllers\Products;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products\PROD02V1Products;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Products\PROD02V1ProductsCategory;
use App\Http\Controllers\IncludeSectionsController;

class PROD02V1CategoryController extends Controller
{
    protected $path = 'uploads/Products/PROD02V1/images/';

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
        $data['slug'] = Str::slug($data['title']);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(PROD02V1ProductsCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD02V1ProductsCategory  $PROD02V1ProductsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PROD02V1ProductsCategory $PROD02V1ProductsCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($PROD02V1ProductsCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($PROD02V1ProductsCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($PROD02V1ProductsCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD02V1ProductsCategory  $PROD02V1ProductsCategory
     * @return \Illuminate\Http\Response
     */

    public function destroy(PROD02V1ProductsCategory $PROD02V1ProductsCategory)
    {
        $categoryWithProducts = PROD02V1ProductsCategory::join('prod02_products', 'prod02_products.category_id', '=', 'prod02_products_categories.id')
            ->where('prod02_products_categories.id', $PROD02V1ProductsCategory->id)
            ->select('prod02_products_categories.*', 'prod02_products.id as product_id')
            ->first();

        // verifica se existem produtos atrelados à categoria
        if ($categoryWithProducts) {
            Session::flash('error', 'Não é possível excluir esta categoria porque existem produtos atrelados a ela.');
            return redirect()->back();
        } else {
            // não há produtos atrelados à categoria, pode ser excluída
            storageDelete($PROD02V1ProductsCategory, 'path_image_icon');
            if ($PROD02V1ProductsCategory->delete()) {
                Session::flash('success', 'Categoria deletada com sucessso');
                return redirect()->back();
            }
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
        $PROD02V1ProductsCategorys = PROD02V1ProductsCategory::whereIn('id', $request->deleteAll)->get();
        foreach($PROD02V1ProductsCategorys as $PROD02V1ProductsCategory){
            storageDelete($PROD02V1ProductsCategory, 'path_image_icon');
        }


        if($deleted = PROD02V1ProductsCategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Categorias deletados com sucessso']);
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
            PROD02V1ProductsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
