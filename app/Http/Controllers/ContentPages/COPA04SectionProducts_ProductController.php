<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\ContentPages\COPA04ContentPages;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesSectionProducts;
use App\Models\ContentPages\COPA04ContentPagesSectionProducts_Product;

class COPA04SectionProducts_ProductController extends Controller
{

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionProductItem.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA04')
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if(COPA04ContentPagesSectionProducts_Product::create($data)){
            $COPA04ContentPages = COPA04ContentPages::first();
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.copa04.edit', [$COPA04ContentPages->id]);
        }else{
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    public function edit(COPA04ContentPagesSectionProducts_Product $Products)
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionProductItem.edit', [
            'cropSetting' => getCropImage('ContentPages', 'COPA04'),
            'Products' => $Products
        ]);
    }


    public function update(Request $request, COPA04ContentPagesSectionProducts_Product $Products)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($Products->fill($data)->save()){
            $COPA04ContentPages = COPA04ContentPages::first();
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.copa04.edit', [$COPA04ContentPages->id]);
        }else{
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }


    public function destroy(COPA04ContentPagesSectionProducts_Product $Products)
    {

        if($Products->delete()){
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
