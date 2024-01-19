<?php

namespace App\Http\Controllers\Units;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Units\UNIT01Units;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Units\UNIT01UnitsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT01CategoryController extends Controller
{
    protected $path = 'uploads/Units/UNIT01/images/';

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
        $data['slug'] = Str::slug($request->title);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(UNIT01UnitsCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT01UnitsCategory  $UNIT01UnitsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT01UnitsCategory $UNIT01UnitsCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        $data['slug'] = Str::slug($request->title);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($UNIT01UnitsCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($UNIT01UnitsCategory, 'path_image');
            $data['path_image'] = null;
        }


        if($UNIT01UnitsCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT01UnitsCategory  $UNIT01UnitsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT01UnitsCategory $UNIT01UnitsCategory)
    {
        if(UNIT01Units::where('category_id', $UNIT01UnitsCategory->id)->count()) {
            Session::flash('error', 'Não é possível excluir a categoria porque existem unidades associadas a ela.');
            return redirect()->back();
        }

        storageDelete($UNIT01UnitsCategory, 'path_image');

        if($UNIT01UnitsCategory->delete()){
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
        $serviceExist = UNIT01Units::whereIn('category_id', $categoryIds)->exists();
        if ($serviceExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem unidades associadas a elas.'
            ]);
        }

        // Excluir as categorias
        $deletedCategories = UNIT01UnitsCategory::whereIn('id', $categoryIds)->get();
        foreach ($deletedCategories as $category) {
            storageDelete($category, 'path_image');
        }

        if ($deleted = UNIT01UnitsCategory::whereIn('id', $categoryIds)->delete()) {
            return Response::json(['status' => 'success','message' => $deleted . ' categorias deletadas com sucesso']);
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
            UNIT01UnitsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
