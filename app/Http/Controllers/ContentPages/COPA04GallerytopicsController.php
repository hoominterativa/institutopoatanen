<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\ContentPages\COPA04ContentPages;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesGallery;
use App\Models\ContentPages\COPA04ContentPagesGallerytopics;

class COPA04GallerytopicsController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA04/images/gallery/';

    public function create()
    {
        $COPA04ContentPages = COPA04ContentPages::first();
        return view('Admin.cruds.ContentPages.COPA04.GalleryTopics.create',[
            'cropSetting' => getCropImage('ContentPages', 'COPA04'),
            'COPA04ContentPages' => $COPA04ContentPages
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);

        if($path_image) $data['path_image'] = $path_image;
        if(COPA04ContentPagesGallerytopics::create($data)){
            $COPA04ContentPages = COPA04ContentPages::first();

            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.copa04.edit', [$COPA04ContentPages->id]);
        }else{

            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }


    public function edit(COPA04ContentPagesGallerytopics $COPA04ContentPagesGallerytopics)
    {
        $COPA04ContentPages = COPA04ContentPages::first();
        return view('Admin.cruds.ContentPages.COPA04.GalleryTopics.edit', [
            'cropSetting' => getCropImage('ContentPages', 'COPA04'),
            'COPA04ContentPagesGallerytopics' => $COPA04ContentPagesGallerytopics,
            'COPA04ContentPages' => $COPA04ContentPages
        ]);
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
            $COPA04ContentPages = COPA04ContentPages::first();
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.copa04.edit', [$COPA04ContentPages->id]);
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
