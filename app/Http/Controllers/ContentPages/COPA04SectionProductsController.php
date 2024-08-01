<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesSectionProducts;
use App\Models\ContentPages\COPA04ContentPagesSectionProducts_Product;

class COPA04SectionProductsController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionProducts.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($SectionProducts = COPA04ContentPagesSectionProducts::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.copa04.sectionProduct.edit', [$SectionProducts->id]);
        }else{
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }


    public function edit(COPA04ContentPagesSectionProducts $SectionProducts)
    {  
        $sectionProductItems = COPA04ContentPagesSectionProducts_Product::paginate(30);

        return view('Admin.cruds.ContentPages.COPA04.SectionProducts.edit', [
            'SectionProducts' => $SectionProducts,
            'sectionProductItems' => $sectionProductItems
        ]);
    }


    public function update(Request $request, COPA04ContentPagesSectionProducts $SectionProducts)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        
        if($SectionProducts->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.copa04.sectionProduct.edit', [$SectionProducts->id]);
        }else{
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesSectionProducts $SectionProducts)
    {
        if($SectionProducts->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesSectionProducts  $COPA04ContentPagesSectionProducts
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesSectionProducts $COPA04ContentPagesSectionProducts)
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
