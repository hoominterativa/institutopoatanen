<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\ContentPages\COPA04ContentPagesFaq;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesFaqTopics;

class COPA04FaqController extends Controller
{
    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.Faq.create');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($faq = COPA04ContentPagesFaq::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.copa04.faq.edit', [$faq->id]);
        }else{
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    public function edit(COPA04ContentPagesFaq $COPA04ContentPagesFaq)
    {   
        $faqs = COPA04ContentPagesFaqTopics::sorting()->paginate(30);
        return view('Admin.cruds.ContentPages.COPA04.Faq.edit', [
            'COPA04ContentPagesFaq' => $COPA04ContentPagesFaq,
            'faqs' => $faqs
        ]);
    }

    public function update(Request $request, COPA04ContentPagesFaq $COPA04ContentPagesFaq)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($COPA04ContentPagesFaq->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->back();
        }else{
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesFaq $COPA04ContentPagesFaq)
    {

        if($COPA04ContentPagesFaq->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesFaq  $COPA04ContentPagesFaq
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesFaq $COPA04ContentPagesFaq)
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
