<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\ContentPages\COPA04ContentPages;
use App\Models\ContentPages\COPA04ContentPagesFaq;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesFaqTopics;

class COPA04FaqTopicsController extends Controller
{

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.FaqTopics.create');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if(COPA04ContentPagesFaqTopics::create($data)){
            $COPA04ContentPages = COPA04ContentPages::first();
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.copa04.edit', [$COPA04ContentPages->id]);
        }else{
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }


    public function edit(COPA04ContentPagesFaqTopics $COPA04ContentPagesFaqTopics)
    {
        return view('Admin.cruds.ContentPages.COPA04.FaqTopics.edit', compact('COPA04ContentPagesFaqTopics'));
    }

    public function update(Request $request, COPA04ContentPagesFaqTopics $COPA04ContentPagesFaqTopics)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if($COPA04ContentPagesFaqTopics->fill($data)->save()){
            $COPA04ContentPages = COPA04ContentPages::first();
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.copa04.edit', [$COPA04ContentPages->id]);
        }else{
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesFaqTopics $COPA04ContentPagesFaqTopics)
    {

        if($COPA04ContentPagesFaqTopics->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    public function destroySelected(Request $request)
    {

        if($deleted = COPA04ContentPagesFaqTopics::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }


    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            COPA04ContentPagesFaqTopics::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesFaqTopics  $COPA04ContentPagesFaqTopics
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesFaqTopics $COPA04ContentPagesFaqTopics)
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
