<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA04ContentPagesSectionProducts_Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA04SectionProducts_ProductController extends Controller
{

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionProducts.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if(COPA04ContentPagesSectionProducts_Product::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    public function edit(COPA04ContentPagesSectionProducts_Product $COPA04ContentPagesSectionProducts_Product)
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionProducts.products.edit', compact('COPA04ContentPagesSectionProducts_Product'));
    }


    public function update(Request $request, COPA04ContentPagesSectionProducts_Product $COPA04ContentPagesSectionProducts_Product)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($COPA04ContentPagesSectionProducts_Product->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }


    public function destroy(COPA04ContentPagesSectionProducts_Product $COPA04ContentPagesSectionProducts_Product)
    {

        if($COPA04ContentPagesSectionProducts_Product->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    public function destroySelected(Request $request)
    {
        if($deleted = COPA04ContentPagesSectionProducts_Product::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            COPA04ContentPagesSectionProducts_Product::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesSectionProducts_Product  $COPA04ContentPagesSectionProducts_Product
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesSectionProducts_Product $COPA04ContentPagesSectionProducts_Product)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model', 'show');

        return view('Client.pages.Module.Model.show',[
            'sections' => $sections
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model', 'page');

        return view('Client.pages.Module.Model.page',[
            'sections' => $sections
        ]);
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
