<?php

namespace App\Http\Controllers\Blogs;

use App\Models\Blogs\BLOG01BlogsCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class BLOG01CategoryController extends Controller
{
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

        $path = 'uploads/Module/Code/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 200, 80);

        if($path_image) $data['path_image'] = $path_image;

        Use the code below to upload archive, if not, delete code

        $path = 'uploads/Module/Code/archives/';
        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $path);

        if($path_archive) $data['path_archive'] = $path_archive;

        */

        if(BLOG01BlogsCategory::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            //Storage::delete($path_image);
            //Storage::delete($path_archive);
            Session::flash('success', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blogs\BLOG01BlogsCategory  $BLOG01BlogsCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BLOG01BlogsCategory $BLOG01BlogsCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blogs\BLOG01BlogsCategory  $BLOG01BlogsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BLOG01BlogsCategory $BLOG01BlogsCategory)
    {
        $data = $request->all();

        /*
        Use the code below to upload image, if not, delete code

        $path = 'uploads/Module/Code/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 200, 80);
        if($path_image){
            storageDelete($BLOG01BlogsCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($BLOG01BlogsCategory, 'path_image');
            $data['path_image'] = null;
        }
        */

        /*
        Use the code below to upload archive, if not, delete code

        $path = 'uploads/Module/Code/archives/';
        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $path);

        if($path_archive){
            storageDelete($BLOG01BlogsCategory, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($BLOG01BlogsCategory, 'path_archive');
            $data['path_archive'] = null;
        }

        */

        if($BLOG01BlogsCategory->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            //Storage::delete($path_image);
            //Storage::delete($path_archive);
            Session::flash('success', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blogs\BLOG01BlogsCategory  $BLOG01BlogsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BLOG01BlogsCategory $BLOG01BlogsCategory)
    {
        //storageDelete($BLOG01BlogsCategory, 'path_image');
        //storageDelete($BLOG01BlogsCategory, 'path_archive');

        if($BLOG01BlogsCategory->delete()){
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

        $BLOG01BlogsCategorys = BLOG01BlogsCategory::whereIn('id', $request->deleteAll)->get();
        foreach($BLOG01BlogsCategorys as $BLOG01BlogsCategory){
            storageDelete($BLOG01BlogsCategory, 'path_image');
            storageDelete($BLOG01BlogsCategory, 'path_archive');
        }
        */

        if($deleted = BLOG01BlogsCategory::whereIn('id', $request->deleteAll)->delete()){
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
            BLOG01BlogsCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Blogs\BLOG01BlogsCategory  $BLOG01BlogsCategory
     * @return \Illuminate\Http\Response
     */
    //public function show(BLOG01BlogsCategory $BLOG01BlogsCategory)
    public function show()
    {
        //
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model');

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
