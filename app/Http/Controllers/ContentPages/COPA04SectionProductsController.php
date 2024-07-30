<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA04ContentPagesSectionProducts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

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

        if(COPA04ContentPagesSectionProducts::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }


    public function edit(COPA04ContentPagesSectionProducts $COPA04ContentPagesSectionProducts)
    {
       return view('Admin.cruds.ContentPages.COPA04.SectionProducts.edit', compact('COPA04ContentPagesSectionProducts'));
    }


    public function update(Request $request, COPA04ContentPagesSectionProducts $COPA04ContentPagesSectionProducts)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        
        if($COPA04ContentPagesSectionProducts->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesSectionProducts $COPA04ContentPagesSectionProducts)
    {
        if($COPA04ContentPagesSectionProducts->delete()){
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
