<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV12ServicesVideo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV12VideoController extends Controller
{
    protected $path = 'uploads/Services/SERV12/images/';

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

        $data['active'] = $request->active ? 1 : 0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(SERV12ServicesVideo::create($data)){
            Session::flash('success', 'Vídeo cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o vídeo');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV12ServicesVideo  $SERV12ServicesVideo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV12ServicesVideo $SERV12ServicesVideo)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV12ServicesVideo, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV12ServicesVideo, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV12ServicesVideo->fill($data)->save()){
            Session::flash('success', 'Vídeo atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar vídeo');
        }
        return redirect()->back();
    }
}
