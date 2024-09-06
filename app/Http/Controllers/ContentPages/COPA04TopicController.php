<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesTopic;
use App\Models\ContentPages\COPA04ContentPagesTopicItem;

class COPA04TopicController extends Controller
{
    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionTopic.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?:0;
        if(COPA04ContentPagesTopic::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso!');
            return redirect()->back();
        }else{
            Session::flash('error', 'Erro ao cadastradar o item!');
            return redirect()->back();
        }
    }

    public function edit(COPA04ContentPagesTopic $COPA04ContentPagesTopic)
    {
        $topics = COPA04ContentPagesTopicItem::sorting()->paginate(30);
        
        return view('Admin.cruds.ContentPages.COPA04.SectionTopic.edit', [
            'COPA04ContentPagesTopic' => $COPA04ContentPagesTopic,
            'topics' => $topics
        ]);
    }

    public function update(Request $request, COPA04ContentPagesTopic $COPA04ContentPagesTopic)
    {
        $data = $request->all();
        $data['active'] = $request->active?:0;
        if($COPA04ContentPagesTopic->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso!');
            return redirect()->back();
        }else{
            Session::flash('error', 'Erro ao atualizar item!');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesTopic $COPA04ContentPagesTopic)
    {

        if($COPA04ContentPagesTopic->delete()){
            Session::flash('success', 'Item deletado com sucessso!');
            return redirect()->back();
        }
    }

    /**
     * Remove the selected resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {
        if($deleted = COPA04ContentPagesTopic::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesTopic  $COPA04ContentPagesTopic
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesTopic $COPA04ContentPagesTopic)
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
