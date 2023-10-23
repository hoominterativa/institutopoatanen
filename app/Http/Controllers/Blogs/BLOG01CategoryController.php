<?php

namespace App\Http\Controllers\Blogs;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Blogs\BLOG01Blogs;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Blogs\BLOG01BlogsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class BLOG01CategoryController extends Controller
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
        $data['slug'] = Str::slug($request->title);
        $data['active'] = $request->active ? 1 : 0;

        if (BLOG01BlogsCategory::create($data)) {
            Session::flash('success', 'Categoria cadastrada com sucesso');
            return redirect()->route('admin.blog01.index');
        } else {
            Session::flash('success', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blogs\BLOG01BlogsCategory  $BLOG01BlogsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BLOG01BlogsCategory $BLOG01BlogsCategory)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['active'] = $request->active ? 1 : 0;

        if ($BLOG01BlogsCategory->fill($data)->save()) {
            Session::flash('success', 'Categoria atualizada com sucesso');
            return redirect()->route('admin.blog01.index');
        } else {
            Session::flash('success', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blogs\BLOG01BlogsCategory  $BLOG01BlogsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BLOG01BlogsCategory $BLOG01BlogsCategory)
    {

        if(BLOG01Blogs::where('category_id', $BLOG01BlogsCategory->id)->count()){
            Session::flash('error', 'Não é possível excluir a categoria porque existem artigos associadas a ela.');
            return redirect()->back();
        }

        if($BLOG01BlogsCategory->delete()){
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
        $serviceExist = BLOG01Blogs::whereIn('category_id', $categoryIds)->exists();
        if ($serviceExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem artigos associadas a elas.'
            ]);
        }

        if ($deleted = BLOG01BlogsCategory::whereIn('id', $categoryIds)->delete()) {
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
        foreach ($request->arrId as $sorting => $id) {
            BLOG01BlogsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
