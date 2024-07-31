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

class COPA04AdditionalContentImagesController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';


    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.AdditionalContentImages.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA01'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;


        if(COPA04ContentPagesAdditionalContentImages::create($data)){
            $additionalContent = COPA04ContentPagesAdditionalContent::first();
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.copa04.additionalContent.edit', [$additionalContent->id]);
        }else{

            Storage::delete($path_image);

            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }


    public function edit(COPA04ContentPagesAdditionalContentImages $AdditionalContentImages)
    {
        return view('Admin.cruds.ContentPages.COPA04.AdditionalContentImages.edit', [
            'cropSetting' => getCropImage('ContentPages', 'COPA01'),
            'AdditionalContentImages' => $AdditionalContentImages
        ]);
    }

    public function update(Request $request, COPA04ContentPagesAdditionalContentImages $AdditionalContentImages)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($AdditionalContentImages, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($AdditionalContentImages, 'path_image');
            $data['path_image'] = null;
        }


        if($AdditionalContentImages->fill($data)->save()){
            $additionalContent = COPA04ContentPagesAdditionalContent::first();
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.copa04.additionalContent.edit', [$additionalContent->id]);
        }else{
            
            Storage::delete($path_image);

            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesAdditionalContentImages $AdditionalContentImages)
    {
       storageDelete($AdditionalContentImages, 'path_image');


        if($AdditionalContentImages->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }


    public function destroySelected(Request $request)
    {

        $AdditionalContentImages = COPA04ContentPagesAdditionalContentImages::whereIn('id', $request->deleteAll)->get();
        foreach($AdditionalContentImages as $AdditionalContentImage){
            storageDelete($AdditionalContentImage, 'path_image');
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
