<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT08Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT08ContentsTopic;

class CONT08Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT08/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = CONT08Contents::first();
        $topics = CONT08ContentsTopic::sorting()->get();
        return view('Admin.cruds.Contents.CONT08.edit',[
            'content' => $content,
            'topics' => $topics,
            'cropSetting' => getCropImage('Contents', 'CONT08')
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

        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;



        if(CONT08Contents::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT08Contents  $CONT08Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT08Contents $CONT08Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image){
            storageDelete($CONT08Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($CONT08Contents, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop){
            storageDelete($CONT08Contents, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($CONT08Contents, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile){
            storageDelete($CONT08Contents, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($CONT08Contents, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($CONT08Contents->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
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
        $content = CONT08Contents::first();
        $topics = CONT08ContentsTopic::active()->sorting()->get();
        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($content) $content->path_image_desktop = $content->path_image_mobile;
            break;

        }

        return view('Client.pages.Contents.CONT08.section',[
            'content' => $content,
            'topics' => $topics
        ]);
    }
}
