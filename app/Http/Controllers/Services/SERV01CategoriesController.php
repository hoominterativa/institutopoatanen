<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV01ServicesCategories;

class SERV01CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = SERV01ServicesCategories::sorting()->paginate('32');
        return view('Admin.cruds.Services.SERV01.Categories.index',[
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Services.SERV01.Categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $SERV01ServicesCategories = new SERV01ServicesCategories();
        $SERV01ServicesCategories->name = $request->name;
        $SERV01ServicesCategories->active = $request->active?:0;
        $SERV01ServicesCategories->slug = Str::slug($request->name, '-', 'pt_BR');

        if($SERV01ServicesCategories->save()){
            Session::flash('success', 'Categoria cadastrada com sucessso');
            return redirect()->route('admin.serv01.category.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV01ServicesCategories  $SERV01ServicesCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV01ServicesCategories $SERV01ServicesCategories)
    {
        return view('Admin.cruds.Services.SERV01.Categories.edit',[
            'category' => $SERV01ServicesCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01ServicesCategories  $SERV01ServicesCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01ServicesCategories $SERV01ServicesCategories)
    {
        $SERV01ServicesCategories->name = $request->name;
        $SERV01ServicesCategories->active = $request->active?:0;
        $SERV01ServicesCategories->slug = Str::slug($request->name, '-', 'pt_BR');

        if($SERV01ServicesCategories->save()){
            Session::flash('success', 'Categoria atualizada com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV01ServicesCategories  $SERV01ServicesCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV01ServicesCategories $SERV01ServicesCategories)
    {
        if($SERV01ServicesCategories->delete()){
            Session::flash('success', 'Categoria deletada com sucessso');
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
        if($deleted = SERV01ServicesCategories::whereIn('id', $request->deleteAll)->delete()){
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
            SERV01ServicesCategories::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV01ServicesCategories  $SERV01ServicesCategories
     * @return \Illuminate\Http\Response
     */
    public function show(SERV01ServicesCategories $SERV01ServicesCategories)
    {

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
