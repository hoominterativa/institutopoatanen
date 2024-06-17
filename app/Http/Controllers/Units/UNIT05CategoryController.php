<?php

namespace App\Http\Controllers\Units;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Units\UNIT05UnitsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT05CategoryController extends Controller
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

        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        if($request->title) $data['slug'] = Str::slug($request->title);

        if(UNIT05UnitsCategory::create($data)){
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
     * @param  \App\Models\Units\UNIT05UnitsCategory  $UNIT05UnitsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT05UnitsCategory $UNIT05UnitsCategory)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        if($request->title) $data['slug'] = Str::slug($request->title);

        if($UNIT05UnitsCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT05UnitsCategory  $UNIT05UnitsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT05UnitsCategory $UNIT05UnitsCategory)
    {
        if($UNIT05UnitsCategory->delete()){
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
        if($deleted = UNIT05UnitsCategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' categorias deletadas com sucessso']);
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
            UNIT05UnitsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
