<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA04ContentPagesTopiccarousel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\IncludeSectionsController;

class COPA04TopiccarouselController extends Controller
{

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.TopicCarousel.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if(COPA04ContentPagesTopiccarousel::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso!');
            return redirect()->route('admin.copa04.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar o item!');
            return redirect()->back();
        }
    }


    public function edit(COPA04ContentPagesTopiccarousel $COPA04ContentPagesTopiccarousel)
    {
        return view('Admin.cruds.ContentPages.COPA04.TopicCarousel.edit', [
            'COPA04ContentPagesTopiccarousel' => $COPA04ContentPagesTopiccarousel
        ]);
    }

    public function update(Request $request, COPA04ContentPagesTopiccarousel $COPA04ContentPagesTopiccarousel)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        if($COPA04ContentPagesTopiccarousel->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso!');
            return redirect()->route('admin.copa04.index');
        }else{
            Session::flash('error', 'Erro ao atualizar item!');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesTopiccarousel $COPA04ContentPagesTopiccarousel)
    {
        if($COPA04ContentPagesTopiccarousel->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesTopiccarousel  $COPA04ContentPagesTopiccarousel
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesTopiccarousel $COPA04ContentPagesTopiccarousel)
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
