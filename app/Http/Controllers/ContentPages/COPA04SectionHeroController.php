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
use App\Models\ContentPages\COPA04ContentPagesSectionHero;

class COPA04SectionHeroController extends Controller
{
    protected $path = 'uploads/Module/sectionHeros/images/';


    public function index()
    {

    }

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionHero.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA04')
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_logo = $helper->optimizeImage($request, 'path_logo', $this->path, null,100);
        if($path_logo) $data['path_logo'] = $path_logo;

        $path_icon = $helper->optimizeImage($request, 'path_icon', $this->path, null,100);
        if($path_icon) $data['path_icon'] = $path_icon;

        if(COPA04ContentPagesSectionHero::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso!');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_logo);
            Storage::delete($path_icon);
            Session::flash('error', 'Erro ao cadastradar o item!');
        }

        return redirect()->back();
    }

    public function edit(COPA04ContentPagesSectionHero $COPA04ContentPagesSectionHero)
    {
        return view('Admin.cruds.ContentPages.COPA04.SectionHero.edit', [
            'COPA04ContentPagesSectionHero' => $COPA04ContentPagesSectionHero,
            'cropSetting' => getCropImage('ContentPages', 'COPA04')
        ]);
    }

    public function update(Request $request, COPA04ContentPagesSectionHero $COPA04ContentPagesSectionHero)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        $path_logo = $helper->optimizeImage($request, 'path_logo', $this->path, null,100);
        $path_icon = $helper->optimizeImage($request, 'path_icon', $this->path, null,100);

        if($path_image){
            storageDelete($COPA04ContentPagesSectionHero, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($path_logo){
            storageDelete($COPA04ContentPagesSectionHero, 'path_logo');
            $data['path_logo'] = $path_logo;
        }
        if($path_icon){
            storageDelete($COPA04ContentPagesSectionHero, 'path_icon');
            $data['path_icon'] = $path_icon;
        }

        if($request->delete_path_image && !$path_image){
            storageDelete($COPA04ContentPagesSectionHero, 'path_image');
            $data['path_image'] = null;
        }
        if($request->delete_path_logo && !$path_logo){
            storageDelete($COPA04ContentPagesSectionHero, 'path_logo');
            $data['path_logo'] = null;
        }
        if($request->delete_path_icon && !$path_icon){
            storageDelete($COPA04ContentPagesSectionHero, 'path_icon');
            $data['path_icon'] = null;
        }

        if($COPA04ContentPagesSectionHero->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_logo);
            Storage::delete($path_icon);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    public function destroy(COPA04ContentPagesSectionHero $COPA04ContentPagesSectionHero)
    {
        storageDelete($COPA04ContentPagesSectionHero, 'path_image');

        if($COPA04ContentPagesSectionHero->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    public function destroySelected(Request $request)
    {

        $COPA04ContentPagesSectionHeros = COPA04ContentPagesSectionHero::whereIn('id', $request->deleteAll)->get();
        foreach($COPA04ContentPagesSectionHeros as $COPA04ContentPagesSectionHero){
            storageDelete($COPA04ContentPagesSectionHero, 'path_image');
            storageDelete($COPA04ContentPagesSectionHero, 'path_logo');
            storageDelete($COPA04ContentPagesSectionHero, 'path_icon');
        }


        if($deleted = COPA04ContentPagesSectionHero::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }


    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            COPA04ContentPagesSectionHero::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesSectionHero  $COPA04ContentPagesSectionHero
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesSectionHero $COPA04ContentPagesSectionHero)
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
