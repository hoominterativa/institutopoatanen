<?php

namespace App\Http\Controllers\Galleries;

use App\Models\Galleries\GALL01Galleries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class GALL01Controller extends Controller
{

    protected $path = 'uploads/Galleries/GALL01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = GALL01Galleries::sorting()->paginate(15);

        return view('Admin.cruds.Galleries.GALL01.index', [
            'galleries' => $galleries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Galleries.GALL01.create', [
            'cropSetting' => getCropImage('Galleries', 'GALL01')
        ]);
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
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image) $data['path_image'] = $path_image;

        if(GALL01Galleries::create($data)){
            Session::flash('success', 'Imagem cadastrado com sucesso');
            return redirect()->route('admin.gall01.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar a imagem');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galleries\GALL01Galleries  $GALL01Galleries
     * @return \Illuminate\Http\Response
     */
    public function edit(GALL01Galleries $GALL01Galleries)
    {
        return view('Admin.cruds.Galleries.GALL01.edit', [
            'gallery' => $GALL01Galleries,
            'cropSetting' => getCropImage('Galleries', 'GALL01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galleries\GALL01Galleries  $GALL01Galleries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GALL01Galleries $GALL01Galleries)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image){
            storageDelete($GALL01Galleries, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($GALL01Galleries, 'path_image');
            $data['path_image'] = null;
        }

        if($GALL01Galleries->fill($data)->save()){
            Session::flash('success', 'Imagem atualizada com sucesso');
            return redirect()->route('admin.gall01.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a imagem');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galleries\GALL01Galleries  $GALL01Galleries
     * @return \Illuminate\Http\Response
     */
    public function destroy(GALL01Galleries $GALL01Galleries)
    {
        storageDelete($GALL01Galleries, 'path_image');

        if($GALL01Galleries->delete()){
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

        $GALL01Galleriess = GALL01Galleries::whereIn('id', $request->deleteAll)->get();
        foreach($GALL01Galleriess as $GALL01Galleries){
            storageDelete($GALL01Galleries, 'path_image');
        }

        if($deleted = GALL01Galleries::whereIn('id', $request->deleteAll)->delete()){
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
            GALL01Galleries::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $galleries = GALL01Galleries::active()->sorting()->get();

        return view('Client.pages.Galleries.GALL01.section', [
            'galleries' => $galleries
        ]);
    }
}
