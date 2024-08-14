<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesAdditionalContent;
use App\Models\ContentPages\COPA04ContentPagesAdditionalContentImages;

class COPA04AdditionalContentController extends Controller
{
    //protected $path = 'uploads/ContentPages/COPA04/images/additionalcontent/';


    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.AdditionalContent.create');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($AdditionalContent = COPA04ContentPagesAdditionalContent::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.copa04.additionalContent.edit', [$AdditionalContent->id]);
        }else{

            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    
    public function edit(COPA04ContentPagesAdditionalContent $AdditionalContent)
    {
        $AdditionalContentImages = COPA04ContentPagesAdditionalContentImages::sorting()->paginate(30);
        return view('Admin.cruds.ContentPages.COPA04.AdditionalContent.edit',[
            'AdditionalContent' => $AdditionalContent,
            'AdditionalContentImages' => $AdditionalContentImages
        ]);
    }

    public function update(Request $request, COPA04ContentPagesAdditionalContent $AdditionalContent)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($AdditionalContent->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.copa04.additionalContent.edit', [$AdditionalContent->id]);
        }else{
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }


    public function destroy(COPA04ContentPagesAdditionalContent $AdditionalContent)
    {
        if($AdditionalContent->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }


    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesAdditionalContent  $COPA04ContentPagesAdditionalContent
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesAdditionalContent $COPA04ContentPagesAdditionalContent)
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
