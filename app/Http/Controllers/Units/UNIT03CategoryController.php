<?php

namespace App\Http\Controllers\Units;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Units\UNIT03Units;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Units\UNIT03UnitsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT03CategoryController extends Controller
{
    protected $path = 'uploads/Units/UNIT03/images/';

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
        $data['slug'] = Str::slug($data['title']);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(UNIT03UnitsCategory::create($data)){
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
     * @param  \App\Models\Units\UNIT03UnitsCategory  $UNIT03UnitsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT03UnitsCategory $UNIT03UnitsCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($UNIT03UnitsCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($UNIT03UnitsCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($UNIT03UnitsCategory->fill($data)->save()){
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
     * @param  \App\Models\Units\UNIT03UnitsCategory  $UNIT03UnitsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT03UnitsCategory $UNIT03UnitsCategory)
    {
        // Verificar se existem unidades associadas à categoria
        if (UNIT03Units::where('category_id', $UNIT03UnitsCategory->id)->count()) {
        Session::flash('error', 'Não é possível excluir a categoria porque existem unidades associadas a ela.');
        return redirect()->back();
        }

        // Excluir a categoria
        storageDelete($UNIT03UnitsCategory, 'path_image');

        if($UNIT03UnitsCategory->delete()){
            Session::flash('success', 'categoria deletada com sucessso');
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
        $categoryIds = $request->deleteAll;

        // Verificar se existem unidades associadas às categorias
        $unitsExist = UNIT03Units::whereIn('category_id', $categoryIds)->exists();
        if ($unitsExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem unidades associadas a elas.'
            ]);
        }

        // Excluir as categorias
        $deletedCategories = UNIT03UnitsCategory::whereIn('id', $categoryIds)->get();

        foreach ($deletedCategories as $category) {
            storageDelete($category, 'path_image_icon');
        }

        if ($deleted = UNIT03UnitsCategory::whereIn('id', $categoryIds)->delete()) {
            return Response::json([
                'status' => 'success',
                'message' => $deleted . ' categorias deletadas com sucesso'
            ]);
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
            UNIT03UnitsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
