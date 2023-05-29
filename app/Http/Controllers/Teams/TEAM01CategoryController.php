<?php

namespace App\Http\Controllers\Teams;

use App\Models\Teams\TEAM01TeamsCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TEAM01CategoryController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        /*
        Use the code below to upload image, if not, delete code

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);

        if($path_image) $data['path_image'] = $path_image;

        Use the code below to upload archive, if not, delete code

        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);

        if($path_archive) $data['path_archive'] = $path_archive;

        */

        if(TEAM01TeamsCategory::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            //Storage::delete($path_image);
            //Storage::delete($path_archive);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teams\TEAM01TeamsCategory  $TEAM01TeamsCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(TEAM01TeamsCategory $TEAM01TeamsCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teams\TEAM01TeamsCategory  $TEAM01TeamsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TEAM01TeamsCategory $TEAM01TeamsCategory)
    {
        $data = $request->all();

        /*
        Use the code below to upload image, if not, delete code

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($TEAM01TeamsCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($TEAM01TeamsCategory, 'path_image');
            $data['path_image'] = null;
        }
        */

        /*
        Use the code below to upload archive, if not, delete code

        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);

        if($path_archive){
            storageDelete($TEAM01TeamsCategory, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($TEAM01TeamsCategory, 'path_archive');
            $data['path_archive'] = null;
        }

        */

        if($TEAM01TeamsCategory->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            //Storage::delete($path_image);
            //Storage::delete($path_archive);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teams\TEAM01TeamsCategory  $TEAM01TeamsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TEAM01TeamsCategory $TEAM01TeamsCategory)
    {
        //storageDelete($TEAM01TeamsCategory, 'path_image');
        //storageDelete($TEAM01TeamsCategory, 'path_archive');

        if($TEAM01TeamsCategory->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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
        /* Use the code below to upload image or archive, if not, delete code

        $TEAM01TeamsCategorys = TEAM01TeamsCategory::whereIn('id', $request->deleteAll)->get();
        foreach($TEAM01TeamsCategorys as $TEAM01TeamsCategory){
            storageDelete($TEAM01TeamsCategory, 'path_image');
            storageDelete($TEAM01TeamsCategory, 'path_archive');
        }
        */

        if($deleted = TEAM01TeamsCategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }
    /**
    * Sort record by dragging and dropping
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            TEAM01TeamsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Teams\TEAM01TeamsCategory  $TEAM01TeamsCategory
     * @return \Illuminate\Http\Response
     */
    //public function show(TEAM01TeamsCategory $TEAM01TeamsCategory)
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
