<?php

namespace App\Http\Controllers\Blogs;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Blogs\BLOG03BlogsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class BLOG03CategoryController extends Controller
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
        $data['active'] = $request->active?1:0;

        if(BLOG03BlogsCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
            return redirect()->route('admin.blog03.index');
        }else{
            Session::flash('success', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blogs\BLOG03BlogsCategory  $BLOG03BlogsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BLOG03BlogsCategory $BLOG03BlogsCategory)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['active'] = $request->active?1:0;

        if($BLOG03BlogsCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
            return redirect()->route('admin.blog03.index');
        }else{
            Session::flash('success', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blogs\BLOG03BlogsCategory  $BLOG03BlogsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BLOG03BlogsCategory $BLOG03BlogsCategory)
    {
        $categoryWithProducts = BLOG03BlogsCategory::join('blog03_blogs', 'blog03_blogs.category_id', '=', 'blog03_blogs_categories.id')
        ->where('blog03_blogs_categories.id', $BLOG03BlogsCategory->id)
        ->select('blog03_blogs_categories.*', 'blog03_blogs.id as blog_id')
        ->first();

    // verifica se existem blogs atrelados à categoria
    if ($categoryWithProducts) {
        Session::flash('error', 'Não é possível excluir esta categoria porque existem blogs atrelados a ela.');
        return redirect()->back();
    } else {
        // não há blogs atrelados à categoria, pode ser excluída
        if ($BLOG03BlogsCategory->delete()) {
            Session::flash('success', 'Categoria deletada com sucessso');
            return redirect()->back();
        }
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
        if($deleted = BLOG03BlogsCategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
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
            BLOG03BlogsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
