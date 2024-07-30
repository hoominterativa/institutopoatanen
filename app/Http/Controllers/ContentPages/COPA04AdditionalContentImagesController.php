<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA04ContentPagesAdditionalContentImages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA04AdditionalContentImagesController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';


    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.AdditionalContent.Image.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;


        if(COPA04ContentPagesAdditionalContentImages::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        }else{

            Storage::delete($path_image);

            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }


    public function edit(COPA04ContentPagesAdditionalContentImages $COPA04ContentPagesAdditionalContentImages)
    {
        return view('Admin.cruds.ContentPages.COPA04.AdditionalContent.Image.edit', compact('COPA04ContentPagesAdditionalContentImages'));
    }

    public function update(Request $request, COPA04ContentPagesAdditionalContentImages $COPA04ContentPagesAdditionalContentImages)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($COPA04ContentPagesAdditionalContentImages, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($COPA04ContentPagesAdditionalContentImages, 'path_image');
            $data['path_image'] = null;
        }


        if($COPA04ContentPagesAdditionalContentImages->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            
            Storage::delete($path_image);

            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesAdditionalContentImages $COPA04ContentPagesAdditionalContentImages)
    {
       storageDelete($COPA04ContentPagesAdditionalContentImages, 'path_image');


        if($COPA04ContentPagesAdditionalContentImages->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }


    public function destroySelected(Request $request)
    {

        $COPA04ContentPagesAdditionalContentImagess = COPA04ContentPagesAdditionalContentImages::whereIn('id', $request->deleteAll)->get();
        foreach($COPA04ContentPagesAdditionalContentImagess as $COPA04ContentPagesAdditionalContentImages){
            storageDelete($COPA04ContentPagesAdditionalContentImages, 'path_image');
        }

        if($deleted = COPA04ContentPagesAdditionalContentImages::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            COPA04ContentPagesAdditionalContentImages::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesAdditionalContentImages  $COPA04ContentPagesAdditionalContentImages
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesAdditionalContentImages $COPA04ContentPagesAdditionalContentImages)
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
