<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA04ContentPagesSectionVideo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA04SectionVideoController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionVideo.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if(COPA04ContentPagesSectionVideo::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso!');
            return redirect()->route('admin.copa04.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar o item!');
            return redirect()->back();
        }
    }

    public function edit(COPA04ContentPagesSectionVideo $COPA04ContentPagesSectionVideo)
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionVideo.edit', [
            'COPA04ContentPagesSectionVideo' => $COPA04ContentPagesSectionVideo
        ]);
    }

    public function update(Request $request, COPA04ContentPagesSectionVideo $COPA04ContentPagesSectionVideo)
    {
        $data = $request->all();

        if($COPA04ContentPagesSectionVideo->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso!');
            return redirect()->route('admin.copa04.index');
        }else{
            Session::flash('error', 'Erro ao atualizar item!');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesSectionVideo $COPA04ContentPagesSectionVideo)
    {
        if($COPA04ContentPagesSectionVideo->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    public function destroySelected(Request $request)
    {

        if($deleted = COPA04ContentPagesSectionVideo::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }


    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            COPA04ContentPagesSectionVideo::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesSectionVideo  $COPA04ContentPagesSectionVideo
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesSectionVideo $COPA04ContentPagesSectionVideo)
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
