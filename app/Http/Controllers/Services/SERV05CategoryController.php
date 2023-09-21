<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV05Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV05ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV05CategoryController extends Controller
{
    protected $path = 'uploads/Services/SERV05/images/';

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
        $data['slug'] = Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image'] = $path_image_icon;

        if(SERV05ServicesCategory::create($data)){
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
     * @param  \App\Models\Services\SERV05ServicesCategory  $SERV05ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV05ServicesCategory $SERV05ServicesCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV05ServicesCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV05ServicesCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($SERV05ServicesCategory->fill($data)->save()){
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
     * @param  \App\Models\Services\SERV05ServicesCategory  $SERV05ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV05ServicesCategory $SERV05ServicesCategory)
    {
        // Verificar se existem serviços associadas à categoria
        if (SERV05Services::where('category_id', $SERV05ServicesCategory->id)->count()) {
            Session::flash('error', 'Não é possível excluir a categoria porque existem serviços associadas a ela.');
            return redirect()->back();
        }
        // Excluir a categoria
        storageDelete($SERV05ServicesCategory, 'path_image_icon');

        if($SERV05ServicesCategory->delete()){
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
        $serviceExist = SERV05Services::whereIn('category_id', $categoryIds)->exists();
        if ($serviceExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem serviços associadas a elas.'
            ]);
        }

        // Excluir as categorias
        $deletedCategories = SERV05ServicesCategory::whereIn('id', $categoryIds)->get();
        foreach ($deletedCategories as $category) {
            storageDelete($category, 'path_image_icon');
        }

        if ($deleted = SERV05ServicesCategory::whereIn('id', $categoryIds)->delete()) {
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
            SERV05ServicesCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
