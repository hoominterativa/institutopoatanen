<?php

namespace App\Http\Controllers\Units;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Units\UNIT05UnitsSubcategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT05SubcategoryController extends Controller
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
        if($request->title) $data['slug'] = Str::slug($request->title);

        if(UNIT05UnitsSubcategory::create($data)){
            Session::flash('success', 'Subcategoria cadastrada com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar a subcategoria');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT05UnitsSubcategory  $UNIT05UnitsSubcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT05UnitsSubcategory $UNIT05UnitsSubcategory)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        if($request->title) $data['slug'] = Str::slug($request->title);

        if($UNIT05UnitsSubcategory->fill($data)->save()){
            Session::flash('success', 'Subcategoria atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a subcategoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT05UnitsSubcategory  $UNIT05UnitsSubcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT05UnitsSubcategory $UNIT05UnitsSubcategory)
    {

        if($UNIT05UnitsSubcategory->delete()){
            Session::flash('success', 'Subcategoria deletada com sucessso');
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

        if($deleted = UNIT05UnitsSubcategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' subcategorias deletadas com sucessso']);
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
            UNIT05UnitsSubcategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
