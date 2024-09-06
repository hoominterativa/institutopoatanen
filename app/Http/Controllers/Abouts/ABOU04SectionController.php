<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU04AboutsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU04SectionController extends Controller
{
    protected $path = 'uploads/Module/About04/Section/images/';

    public function store(Request $request)
    {
        $data = $request->all();

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);

        if($path_image) $data['path_image'] = $path_image;



        if(ABOU04AboutsSection::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->back();
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    public function update(Request $request, ABOU04AboutsSection $ABOU04AboutsSection)
    {
        $data = $request->all();

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($ABOU04AboutsSection, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($ABOU04AboutsSection, 'path_image');
            $data['path_image'] = null;
        }
        


        if($ABOU04AboutsSection->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->back();
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    public function destroy(ABOU04AboutsSection $ABOU04AboutsSection)
    {
        storageDelete($ABOU04AboutsSection, 'path_image');

        if($ABOU04AboutsSection->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    public function destroySelected(Request $request)
    {

        $ABOU04AboutsSections = ABOU04AboutsSection::whereIn('id', $request->deleteAll)->get();
        foreach($ABOU04AboutsSections as $ABOU04AboutsSection){
            storageDelete($ABOU04AboutsSection, 'path_image');
        }
        

        if($deleted = ABOU04AboutsSection::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            ABOU04AboutsSection::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT


    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model', 'show');

        return view('Client.pages.Module.Model.show',[
            'sections' => $sections
        ]);
    }


    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model', 'page');

        return view('Client.pages.Module.Model.page',[
            'sections' => $sections
        ]);
    }


    public static function section()
    {
        return view('');
    }
}
