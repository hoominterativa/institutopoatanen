<?php

namespace App\Http\Controllers\Abouts;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Abouts\ABOU04AboutsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Abouts\ABOU04AboutsGallery;

class ABOU04CategoryController extends Controller
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
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);


        if(ABOU04AboutsCategory::create($data)){
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
     * @param  \App\Models\Abouts\ABOU04AboutsCategory  $ABOU04AboutsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU04AboutsCategory $ABOU04AboutsCategory)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);

        if($ABOU04AboutsCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Abouts\ABOU04AboutsCategory  $ABOU04AboutsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ABOU04AboutsCategory $ABOU04AboutsCategory)
    {
        if(ABOU04AboutsGallery::where('category_id', $ABOU04AboutsCategory->id)->count()){
            Session::flash('error', 'Não é possível excluir a categoria porque existem galerias associadas a ela.');
            return redirect()->back();
        }

        if($ABOU04AboutsCategory->delete()){
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

        // Verificar se existem galerias associadas às categorias
        $serviceExist = ABOU04AboutsGallery::whereIn('category_id', $categoryIds)->exists();
        if ($serviceExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem galerias associadas a elas.'
            ]);
        }

        if ($deleted = ABOU04AboutsCategory::whereIn('id', $categoryIds)->delete()) {
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
            ABOU04AboutsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
