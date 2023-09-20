<?php

namespace App\Http\Controllers\Contacts;

use App\Models\Contacts\COTA03Contacts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COTA03Controller extends Controller
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

        if(COTA03Contacts::create($data)){
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
     * @param  \App\Models\Contacts\COTA03Contacts  $COTA03Contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(COTA03Contacts $COTA03Contacts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA03Contacts  $COTA03Contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA03Contacts $COTA03Contacts)
    {
        $data = $request->all();

        /*
        Use the code below to upload image, if not, delete code

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($COTA03Contacts, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($COTA03Contacts, 'path_image');
            $data['path_image'] = null;
        }
        */

        /*
        Use the code below to upload archive, if not, delete code

        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);

        if($path_archive){
            storageDelete($COTA03Contacts, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($COTA03Contacts, 'path_archive');
            $data['path_archive'] = null;
        }

        */

        if($COTA03Contacts->fill($data)->save()){
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
     * @param  \App\Models\Contacts\COTA03Contacts  $COTA03Contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA03Contacts $COTA03Contacts)
    {
        //storageDelete($COTA03Contacts, 'path_image');
        //storageDelete($COTA03Contacts, 'path_archive');

        if($COTA03Contacts->delete()){
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

        $COTA03Contactss = COTA03Contacts::whereIn('id', $request->deleteAll)->get();
        foreach($COTA03Contactss as $COTA03Contacts){
            storageDelete($COTA03Contacts, 'path_image');
            storageDelete($COTA03Contacts, 'path_archive');
        }
        */

        if($deleted = COTA03Contacts::whereIn('id', $request->deleteAll)->delete()){
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
            COTA03Contacts::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Contacts\COTA03Contacts  $COTA03Contacts
     * @return \Illuminate\Http\Response
     */
    //public function show(COTA03Contacts $COTA03Contacts)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA03', 'show');

        return view('Client.pages.Contacts.COTA03.show',[
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA03', 'page');

        return view('Client.pages.Contacts.COTA03.page',[
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
        return view('Client.pages.Contacts.COTA03.section');
    }
}
