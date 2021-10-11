<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\OptimizePage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class OptimizePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $configModelsMain = config('modelsConfig.InsertModelsMain');
        $listPage = array();

        foreach ($configModelsMain as $models) {
            foreach ($models as $model) {
                if($model->ViewListMenu && !$model->config->anchor){
                    $pathInfo = Str::replace(url(''), '', route($model->config->linkMenu));
                    $page = Str::replace('/','',$pathInfo);
                    $arrayPages = array($page => Str::ucfirst($page));
                    $listPage = array_merge($listPage, $arrayPages);
                }
            }
        }

        return view('Admin.cruds.OptimizePage.create',['listPages' => $listPage]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $optimizePage = new OptimizePage();
        $optimizePage->title = $request->title;
        $optimizePage->author = $request->author;
        $optimizePage->keywords = $request->keywords;
        $optimizePage->description = $request->description;
        $optimizePage->page = $request->page;
        if($optimizePage->save()){
            $request->session()->flash('success', 'Informações cadastradas com sucesso');
            return redirect($request->_previous);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OptimizePage  $optimizePage
     * @return \Illuminate\Http\Response
     */
    public function show(OptimizePage $optimizePage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OptimizePage  $optimizePage
     * @return \Illuminate\Http\Response
     */
    public function edit(OptimizePage $optimizePage)
    {
        $configModelsMain = config('modelsConfig.InsertModelsMain');
        $listPage = array();

        foreach ($configModelsMain as $models) {
            foreach ($models as $model) {
                if($model->ViewListMenu && !$model->config->anchor){
                    $pathInfo = Str::replace(url(''), '', route($model->config->linkMenu));
                    $page = Str::replace('/','',$pathInfo);
                    $arrayPages = array($page => Str::ucfirst($page));
                    $listPage = array_merge($listPage, $arrayPages);
                }
            }
        }

        return view('Admin.cruds.OptimizePage.edit', [
            'optimizePage' => $optimizePage,
            'listPages' => $listPage
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OptimizePage  $optimizePage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptimizePage $optimizePage)
    {
        $optimizePage->title = $request->title;
        $optimizePage->author = $request->author;
        $optimizePage->keywords = $request->keywords;
        $optimizePage->description = $request->description;
        $optimizePage->page = $request->page;
        if($optimizePage->save()){
            $request->session()->flash('success', 'Informações atualizadas com sucesso');
            return redirect($request->_previous);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OptimizePage  $optimizePage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OptimizePage $optimizePage)
    {
        if($optimizePage->delete()){
            $request->session()->flash('success', 'Informações atualizadas com sucesso');
            return redirect($request->_previous);
        }
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {
        if($deleted = OptimizePage::whereIn('id', $request->deleteAll)->delete()){
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
            OptimizePage::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
