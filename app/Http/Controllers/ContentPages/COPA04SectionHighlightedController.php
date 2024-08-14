<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA04ContentPagesSectionHighlighted;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA04SectionHighlightedController extends Controller
{
    protected $path = 'uploads/Module/sectionHighlighted/images/';

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionHighlighted.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA01')
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;


        if(COPA04ContentPagesSectionHighlighted::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso!');
            return redirect()->route('admin.copa04.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item!');
            return redirect()->back();
        }
    }

    public function edit(COPA04ContentPagesSectionHighlighted $COPA04SectionHighlighted)
    {   

        return view('Admin.cruds.ContentPages.COPA04.SectionHighlighted.edit', [
            'COPA04SectionHighlighted' => $COPA04SectionHighlighted,
            'cropSetting' => getCropImage('ContentPages', 'COPA01')
        ]);
    }


    public function update(Request $request, COPA04ContentPagesSectionHighlighted $COPA04SectionHighlighted)
    {
        $data = $request->all();
        $helper = new HelperArchive();
        $data['active'] = $request->active ? 1 : 0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($COPA04SectionHighlighted, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($COPA04SectionHighlighted, 'path_image');
            $data['path_image'] = null;
        }

        if($COPA04SectionHighlighted->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso!');
            return redirect()->route('admin.copa04.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar item!');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesSectionHighlighted $COPA04SectionHighlighted)
    {
        storageDelete($COPA04SectionHighlighted, 'path_image');

        if($COPA04SectionHighlighted->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }
    public function destroySelected(Request $request)
    {


        $COPA04ContentPagesSectionHighlighteds = COPA04ContentPagesSectionHighlighted::whereIn('id', $request->deleteAll)->get();
        foreach($COPA04ContentPagesSectionHighlighteds as $COPA04ContentPagesSectionHighlighted){
            storageDelete($COPA04ContentPagesSectionHighlighted, 'path_image');
        }

        if($deleted = COPA04ContentPagesSectionHighlighted::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            COPA04ContentPagesSectionHighlighted::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesSectionHighlighted  $COPA04ContentPagesSectionHighlighted
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesSectionHighlighted $COPA04ContentPagesSectionHighlighted)
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
