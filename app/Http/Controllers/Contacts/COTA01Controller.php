<?php

namespace App\Http\Controllers\Contacts;

use App\Models\Contacts\COTA01Contacts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COTA01Controller extends Controller
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

        if(COTA01Contacts::create($data)){
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
     * @param  \App\Models\Contacts\COTA01Contacts  $COTA01Contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(COTA01Contacts $COTA01Contacts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA01Contacts  $COTA01Contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA01Contacts $COTA01Contacts)
    {
        $data = $request->all();

        /*
        Use the code below to upload image, if not, delete code

        $path = 'uploads/Module/Code/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 200, 80);
        if($path_image){
            storageDelete($COTA01Contacts, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($COTA01Contacts, 'path_image');
            $data['path_image'] = null;
        }
        */

        /*
        Use the code below to upload archive, if not, delete code

        $path = 'uploads/Module/Code/archives/';
        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $path);

        if($path_archive){
            storageDelete($COTA01Contacts, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($COTA01Contacts, 'path_archive');
            $data['path_archive'] = null;
        }

        */

        if($COTA01Contacts->fill($data)->save()){
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
     * @param  \App\Models\Contacts\COTA01Contacts  $COTA01Contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA01Contacts $COTA01Contacts)
    {
        //storageDelete($COTA01Contacts, 'path_image');
        //storageDelete($COTA01Contacts, 'path_archive');

        if($COTA01Contacts->delete()){
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

        $COTA01Contactss = COTA01Contacts::whereIn('id', $request->deleteAll)->get();
        foreach($COTA01Contactss as $COTA01Contacts){
            storageDelete($COTA01Contacts, 'path_image');
            storageDelete($COTA01Contacts, 'path_archive');
        }
        */

        if($deleted = COTA01Contacts::whereIn('id', $request->deleteAll)->delete()){
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
            COTA01Contacts::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA01');

        return view('Client.pages.Contacts.COTA01.page',[
            'sections' => $sections
        ]);
    }
}
