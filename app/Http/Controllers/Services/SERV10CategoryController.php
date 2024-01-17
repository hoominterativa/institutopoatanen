<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV10ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV10Services;

class SERV10CategoryController extends Controller
{
    protected $path = 'uploads/Services/SERV10/images/';

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        $data['slug'] = Str::slug($request->title);

        if(SERV10ServicesCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV10ServicesCategory  $SERV10ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV10ServicesCategory $SERV10ServicesCategory)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        $data['slug'] = Str::slug($request->title);

        if($SERV10ServicesCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV10ServicesCategory  $SERV10ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV10ServicesCategory $SERV10ServicesCategory)
    {

        if(SERV10Services::where('category_id', $SERV10ServicesCategory->id)->count()) {
            Session::flash('error', 'Não é possível excluir a categoria porque existem serviços associadas a ela.');
            return redirect()->back();
        }

        if($SERV10ServicesCategory->delete()){
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

        // Verificar se existem serviços associadas às categorias
        $serviceExist = SERV10Services::whereIn('category_id', $categoryIds)->exists();
        if ($serviceExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem serviços associadas a elas.'
            ]);
        }

        // Excluir as categorias
        $deletedCategories = SERV10ServicesCategory::whereIn('id', $categoryIds)->get();
        foreach ($deletedCategories as $category) {
            storageDelete($category, 'path_image');
        }

        if ($deleted = SERV10ServicesCategory::whereIn('id', $categoryIds)->delete()) {
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
            SERV10ServicesCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
