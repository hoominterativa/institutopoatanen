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
use App\Models\Portfolios\PORT05PortfoliosCategory;

class PORT05CategoryController extends Controller
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

        $data['featured'] = $request->featured?1:0;
        $data['active'] = $request->active?1:0;
        if($request->title) $data['slug'] = Str::slug($data['title']);

        if(PORT05PortfoliosCategory::create($data)){
            Session::flash('success', 'Categoria cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT05PortfoliosCategory  $PORT05PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT05PortfoliosCategory $PORT05PortfoliosCategory)
    {
        $data = $request->all();

        $data['featured'] = $request->featured?1:0;
        $data['active'] = $request->active?1:0;
        if($request->title) $data['slug'] = Str::slug($data['title']);

        if($PORT05PortfoliosCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT05PortfoliosCategory  $PORT05PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT05PortfoliosCategory $PORT05PortfoliosCategory)
    {

        if($PORT05PortfoliosCategory->delete()){
            Session::flash('success', 'Categoria deletado com sucessso');
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

        if($deleted = PORT05PortfoliosCategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' categorias deletados com sucessso']);
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
            PORT05PortfoliosCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
