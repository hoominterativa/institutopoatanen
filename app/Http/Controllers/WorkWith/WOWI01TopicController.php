<?php

namespace App\Http\Controllers\WorkWith;

use App\Models\WorkWith\WOWI01WorkWithTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class WOWI01TopicController extends Controller
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

        if(WOWI01WorkWithTopic::create($data)){
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
     * @param  \App\Models\WorkWith\WOWI01WorkWithTopic  $WOWI01WorkWithTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(WOWI01WorkWithTopic $WOWI01WorkWithTopic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkWith\WOWI01WorkWithTopic  $WOWI01WorkWithTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WOWI01WorkWithTopic $WOWI01WorkWithTopic)
    {
        $data = $request->all();

        /*
        Use the code below to upload image, if not, delete code

        $path = 'uploads/Module/Code/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 200, 80);
        if($path_image){
            storageDelete($WOWI01WorkWithTopic, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($WOWI01WorkWithTopic, 'path_image');
            $data['path_image'] = null;
        }
        */

        /*
        Use the code below to upload archive, if not, delete code

        $path = 'uploads/Module/Code/archives/';
        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $path);

        if($path_archive){
            storageDelete($WOWI01WorkWithTopic, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($WOWI01WorkWithTopic, 'path_archive');
            $data['path_archive'] = null;
        }

        */

        if($WOWI01WorkWithTopic->fill($data)->save()){
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
     * @param  \App\Models\WorkWith\WOWI01WorkWithTopic  $WOWI01WorkWithTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(WOWI01WorkWithTopic $WOWI01WorkWithTopic)
    {
        //storageDelete($WOWI01WorkWithTopic, 'path_image');
        //storageDelete($WOWI01WorkWithTopic, 'path_archive');

        if($WOWI01WorkWithTopic->delete()){
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

        $WOWI01WorkWithTopics = WOWI01WorkWithTopic::whereIn('id', $request->deleteAll)->get();
        foreach($WOWI01WorkWithTopics as $WOWI01WorkWithTopic){
            storageDelete($WOWI01WorkWithTopic, 'path_image');
            storageDelete($WOWI01WorkWithTopic, 'path_archive');
        }
        */

        if($deleted = WOWI01WorkWithTopic::whereIn('id', $request->deleteAll)->delete()){
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
            WOWI01WorkWithTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\WorkWith\WOWI01WorkWithTopic  $WOWI01WorkWithTopic
     * @return \Illuminate\Http\Response
     */
    //public function show(WOWI01WorkWithTopic $WOWI01WorkWithTopic)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model');

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
