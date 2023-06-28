<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV06Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV06ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV06CategoryController extends Controller
{
    protected $path = 'uploads/Services/SERV06/images/';

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
        $data['slug'] = Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(SERV06ServicesCategory::create($data)){
            Session::flash('success', 'Categoria cadastrado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV06ServicesCategory  $SERV06ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV06ServicesCategory $SERV06ServicesCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV06ServicesCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV06ServicesCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($SERV06ServicesCategory->fill($data)->save()){
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
     * @param  \App\Models\Services\SERV06ServicesCategory  $SERV06ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV06ServicesCategory $SERV06ServicesCategory)
    {
        // Verificar se existem unidades associadas à categoria
        if (SERV06Services::where('category_id', $SERV06ServicesCategory->id)->count()) {
        Session::flash('error', 'Não é possível excluir a categoria porque existem serviços associadas a ela.');
        return redirect()->back();
        }

        // Excluir a categoria
        storageDelete($SERV06ServicesCategory, 'path_image_icon');

        if($SERV06ServicesCategory->delete()){
            Session::flash('success', 'categoria deletado com sucessso');
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

        // Verificar se existem serviços associadas às categorias
        $servicesExist = SERV06Services::whereIn('category_id', $categoryIds)->exists();
        if ($servicesExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem serviços associadas a elas.'
            ]);
        }

        // Excluir as categorias
        $deletedCategories = SERV06ServicesCategory::whereIn('id', $categoryIds)->get();

        foreach ($deletedCategories as $category) {
            storageDelete($category, 'path_image_icon');
        }

        if ($deleted = SERV06ServicesCategory::whereIn('id', $categoryIds)->delete()) {
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
            SERV06ServicesCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
