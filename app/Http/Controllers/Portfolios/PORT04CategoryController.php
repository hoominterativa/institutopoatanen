<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portfolios\PORT04Portfolios;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT04PortfoliosCategory;

class PORT04CategoryController extends Controller
{
    protected $path = 'uploads/Portfolios/PORT04/images/';

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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(PORT04PortfoliosCategory::create($data)){
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
     * @param  \App\Models\Portfolios\PORT04PortfoliosCategory  $PORT04PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT04PortfoliosCategory $PORT04PortfoliosCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($PORT04PortfoliosCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PORT04PortfoliosCategory, 'path_image');
            $data['path_image'] = null;
        }

        if($PORT04PortfoliosCategory->fill($data)->save()){
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
     * @param  \App\Models\Portfolios\PORT04PortfoliosCategory  $PORT04PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT04PortfoliosCategory $PORT04PortfoliosCategory)
    {
        if(PORT04Portfolios::where('category_id', $PORT04PortfoliosCategory->id)->count()){
            Session::flash('error', 'Não é possível excluir a categoria porque existem portifólios associadas a ela.');
            return redirect()->back();
        };
        storageDelete($PORT04PortfoliosCategory, 'path_image');

        if($PORT04PortfoliosCategory->delete()){
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
        $categoryIds = $request->deleteAll;

        // Verificar se existem portifolios associadas às categorias
        $serviceExist = PORT04Portfolios::whereIn('category_id', $categoryIds)->exists();
        if ($serviceExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem portifolios associadas a elas.'
            ]);
        }

        // Excluir as categorias
        $deletedCategories = PORT04PortfoliosCategory::whereIn('id', $categoryIds)->get();
        foreach ($deletedCategories as $category) {
            storageDelete($category, 'path_image_icon');
        }

        if ($deleted = PORT04PortfoliosCategory::whereIn('id', $categoryIds)->delete()) {
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
            PORT04PortfoliosCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
