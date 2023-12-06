<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT03Portfolios;
use App\Models\Portfolios\PORT03PortfoliosCategory;

class PORT03CategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $path = 'uploads/Portfolios/PORT03/images/';
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(PORT03PortfoliosCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
            return redirect()->route('admin.port03.index');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar a categoria');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT03PortfoliosCategory  $PORT03PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT03PortfoliosCategory $PORT03PortfoliosCategory)
    {
        $data = $request->all();
        $path = 'uploads/Portfolios/PORT03/images/';
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $path, null,100);
        if($path_image_icon){
            storageDelete($PORT03PortfoliosCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($PORT03PortfoliosCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($PORT03PortfoliosCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT03PortfoliosCategory  $PORT03PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT03PortfoliosCategory $PORT03PortfoliosCategory)
    {
        if(PORT03Portfolios::where('category_id', $PORT03PortfoliosCategory->id)->count()){
            Session::flash('error', 'Não é possível excluir a categoria porque existem portifólios associadas a ela.');
            return redirect()->back();
        };
        storageDelete($PORT03PortfoliosCategory, 'path_image_icon');

        if($PORT03PortfoliosCategory->delete()){
            Session::flash('success', 'Categoria deletada com sucessso');
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

        // Verificar se existem portifolios associadas às categorias
        $serviceExist = PORT03Portfolios::whereIn('category_id', $categoryIds)->exists();
        if ($serviceExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem portifolios associadas a elas.'
            ]);
        }

        // Excluir as categorias
        $deletedCategories = PORT03PortfoliosCategory::whereIn('id', $categoryIds)->get();
        foreach ($deletedCategories as $category) {
            storageDelete($category, 'path_image_icon');
        }

        if ($deleted = PORT03PortfoliosCategory::whereIn('id', $categoryIds)->delete()) {
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
            PORT03PortfoliosCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
