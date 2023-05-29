<?php

namespace App\Http\Controllers\Blogs;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
        $categoryWithProducts = BLOG01BlogsCategory::join('blog01_blogs', 'blog01_blogs.category_id', '=', 'blog01_blogs_categories.id')
            ->where('blog01_blogs_categories.id', $BLOG01BlogsCategory->id)
            ->select('blog01_blogs_categories.*', 'blog01_blogs.id as blog_id')
            ->first();

        // verifica se existem blogs atrelados à categoria
        if ($categoryWithProducts) {
            Session::flash('error', 'Não é possível excluir esta categoria porque existem blogs atrelados a ela.');
            return redirect()->back();
        } else {
            // não há blogs atrelados à categoria, pode ser excluída
            if ($BLOG01BlogsCategory->delete()) {
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
        if ($deleted = BLOG01BlogsCategory::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' itens deletados com sucessso']);
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
