<?php

namespace App\Http\Controllers\Portals;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Models\Portals\POTA01PortalsCategory;

class POTA01CategoryController extends Controller
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
        $data['view_featured'] = $request->view_featured?1:0;
        $data['view_type'] = $request->view_type?1:0;
        $data['active'] = $request->active?1:0;

        if(POTA01PortalsCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
        }else{
            Session::flash('success', 'Erro ao cadastradar o item');
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portals\POTA01PortalsCategory  $POTA01PortalsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, POTA01PortalsCategory $POTA01PortalsCategory)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['view_featured'] = $request->view_featured?1:0;
        $data['active'] = $request->active?1:0;

        if($POTA01PortalsCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Session::flash('success', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portals\POTA01PortalsCategory  $POTA01PortalsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(POTA01PortalsCategory $POTA01PortalsCategory)
    {
        if($POTA01PortalsCategory->delete()){
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
        if($deleted = POTA01PortalsCategory::whereIn('id', $request->deleteAll)->delete()){
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
            POTA01PortalsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
