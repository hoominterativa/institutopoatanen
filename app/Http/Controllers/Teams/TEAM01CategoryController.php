<?php

namespace App\Http\Controllers\Teams;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Teams\TEAM01Teams;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Teams\TEAM01TeamsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TEAM01CategoryController extends Controller
{
    protected $path = 'uploads/Teams/TEAM01/images/';


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

        if(TEAM01TeamsCategory::create($data)){
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
     * @param  \App\Models\Teams\TEAM01TeamsCategory  $TEAM01TeamsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TEAM01TeamsCategory $TEAM01TeamsCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TEAM01TeamsCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TEAM01TeamsCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($TEAM01TeamsCategory->fill($data)->save()){
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
     * @param  \App\Models\Teams\TEAM01TeamsCategory  $TEAM01TeamsCategory
     * @return \Illuminate\Http\Response
     */

    public function destroy(TEAM01TeamsCategory $TEAM01TeamsCategory)
    {
        // Verificar se existem equipes associadas à categoria
        if (TEAM01Teams::where('category_id', $TEAM01TeamsCategory->id)->count()) {
            Session::flash('error', 'Não é possível excluir a categoria porque existem equipes associadas a ela.');
            return redirect()->back();
        }

        // Excluir a categoria
        storageDelete($TEAM01TeamsCategory, 'path_image_icon');

        if ($TEAM01TeamsCategory->delete()) {
            Session::flash('success', 'Item deletado com sucesso');
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

        // Verificar se existem equipes associadas às categorias
        $teamsExist = TEAM01Teams::whereIn('category_id', $categoryIds)->exists();
        if ($teamsExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem equipes associadas a elas.'
            ]);
        }

        // Excluir as categorias
        $deletedCategories = TEAM01TeamsCategory::whereIn('id', $categoryIds)->get();

        foreach ($deletedCategories as $category) {
            storageDelete($category, 'path_image_icon');
        }

        if ($deleted = TEAM01TeamsCategory::whereIn('id', $categoryIds)->delete()) {
            return Response::json([
                'status' => 'success',
                'message' => $deleted . ' itens deletados com sucesso'
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
            TEAM01TeamsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
