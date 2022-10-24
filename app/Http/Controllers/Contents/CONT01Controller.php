<?php

namespace App\Http\Controllers\Contents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT01Contents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CONT01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = CONT01Contents::first();
        return view('Admin.cruds.Contents.CONT01.edit',[
            'content' => $content
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

        $path = 'uploads/Contents/CONT01/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 600, 90);
        if($path_image) $data['path_image'] = $path_image;

        if(CONT01Contents::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT01Contents  $CONT01Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT01Contents $CONT01Contents)
    {
        $data = $request->all();
        $path = 'uploads/Contents/CONT01/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 600, 90);
        if($path_image){
            storageDelete($CONT01Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($CONT01Contents, 'path_image');
            $data['path_image'] = null;
        }

        if($CONT01Contents->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    // METHODS CLIENT

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $content = CONT01Contents::first();
        return view('Client.pages.Contents.CONT01.section',[
            'content' => $content
        ]);
    }
}
