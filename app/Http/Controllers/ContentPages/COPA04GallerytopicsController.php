<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA04ContentPagesGallerytopics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA04GallerytopicsController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA04/images/gallery/';

    public function create()
    {
       return view('Admin.cruds.ContentPages.COPA04.Gallerytopics.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);

        if($path_image) $data['path_image'] = $path_image;

        if(COPA04ContentPagesGallerytopics::create($data)){

            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        }else{

            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }


    public function edit(COPA04ContentPagesGallerytopics $COPA04ContentPagesGallerytopics)
    {
        return view('Admin.cruds.ContentPages.COPA04.Gallerytopics.edit', compact('COPA04ContentPagesGallerytopics'));
    }


    public function update(Request $request, COPA04ContentPagesGallerytopics $COPA04ContentPagesGallerytopics)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);

        if($path_image){

            storageDelete($COPA04ContentPagesGallerytopics, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){

            storageDelete($COPA04ContentPagesGallerytopics, 'path_image');
            $data['path_image'] = null;
        }
   

        if($COPA04ContentPagesGallerytopics->fill($data)->save()){

            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            Storage::delete($path_image);

            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }


    public function destroy(COPA04ContentPagesGallerytopics $COPA04ContentPagesGallerytopics)
    {
        storageDelete($COPA04ContentPagesGallerytopics, 'path_image');

        if($COPA04ContentPagesGallerytopics->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }


    public function destroySelected(Request $request)
    {
        $COPA04ContentPagesGallerytopicss = COPA04ContentPagesGallerytopics::whereIn('id', $request->deleteAll)->get();
        foreach($COPA04ContentPagesGallerytopicss as $COPA04ContentPagesGallerytopics){
            storageDelete($COPA04ContentPagesGallerytopics, 'path_image');
        }
        if($deleted = COPA04ContentPagesGallerytopics::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }


    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            COPA04ContentPagesGallerytopics::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesGallerytopics  $COPA04ContentPagesGallerytopics
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesGallerytopics $COPA04ContentPagesGallerytopics)
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
