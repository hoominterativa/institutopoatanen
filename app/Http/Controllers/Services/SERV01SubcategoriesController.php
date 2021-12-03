<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV01ServicesSubcategories;

class SERV01SubcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SERV01ServicesSubcategories::sorting()->paginate('32');
        return view('Admin.cruds.Services.SERV01.Subcategories.index',[
            'subcategories' => $subcategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Services.SERV01.Subcategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $SERV01ServicesSubcategories = new SERV01ServicesSubcategories();
        $SERV01ServicesSubcategories->name = $request->name;
        $SERV01ServicesSubcategories->active = $request->active?:0;
        $SERV01ServicesSubcategories->slug = Str::slug($request->name, '-', 'pt_BR');

        if($SERV01ServicesSubcategories->save()){
            Session::flash('success', 'Subcategoria cadastrada com sucessso');
            return redirect()->route('admin.serv01.subcategory.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV01ServicesSubcategories  $SERV01ServicesSubcategories
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV01ServicesSubcategories $SERV01ServicesSubcategories)
    {
        return view('Admin.cruds.Services.SERV01.Subcategories.edit',[
            'subcategory' => $SERV01ServicesSubcategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01ServicesSubcategories  $SERV01ServicesSubcategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01ServicesSubcategories $SERV01ServicesSubcategories)
    {
        $SERV01ServicesSubcategories->name = $request->name;
        $SERV01ServicesSubcategories->active = $request->active?:0;
        $SERV01ServicesSubcategories->slug = Str::slug($request->name, '-', 'pt_BR');

        if($SERV01ServicesSubcategories->save()){
            Session::flash('success', 'Subcategoria atualizada com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV01ServicesSubcategories  $SERV01ServicesSubcategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV01ServicesSubcategories $SERV01ServicesSubcategories)
    {
        if($SERV01ServicesSubcategories->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
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
        if($deleted = SERV01ServicesSubcategories::whereIn('id', $request->deleteAll)->delete()){
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
            SERV01ServicesSubcategories::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV01ServicesSubcategories  $SERV01ServicesSubcategories
     * @return \Illuminate\Http\Response
     */
    public function show(SERV01ServicesSubcategories $SERV01ServicesSubcategories)
    {
        //
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        //
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('');
    }
}
