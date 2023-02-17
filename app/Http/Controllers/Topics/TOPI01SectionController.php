<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI01TopicsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI01SectionController extends Controller
{
    protected $path = 'uploads/Topics/TOPI01/images/';

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

        $path_image_background = $helper->optimizeImage($request, 'path_image_background', $this->path, null,100);
        if($path_image_background) $data['path_image_background'] = $path_image_background;

        if(TOPI01TopicsSection::create($data)){
            Session::flash('success', 'Informações cadastrado com sucesso');
        }else{
            Storage::delete($path_image_background);
            Session::flash('success', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI01TopicsSection  $TOPI01TopicsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI01TopicsSection $TOPI01TopicsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();
        $data['active'] = $request->active?1:0;

        $path_image_background = $helper->optimizeImage($request, 'path_image_background', $this->path, null, 100);
        if($path_image_background){
            storageDelete($TOPI01TopicsSection, 'path_image_background');
            $data['path_image_background'] = $path_image_background;
        }
        if($request->delete_path_image_background && !$path_image_background){
            storageDelete($TOPI01TopicsSection, 'path_image_background');
            $data['path_image_background'] = null;
        }

        if($TOPI01TopicsSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizado com sucesso');
        }else{
            Storage::delete($path_image_background);
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }
}
