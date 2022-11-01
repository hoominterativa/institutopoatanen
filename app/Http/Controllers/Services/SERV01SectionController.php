<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV01ServicesSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SERV01SectionController extends Controller
{
    protected $path = 'uploads/Service/SERV01/images/';

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

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, 1600, 100);
        if($path_image_banner) $data['path_image_banner'] = $path_image_banner;

        $data['active_section'] = $request->active_section?1:0;

        if(SERV01ServicesSection::create($data)){
            Session::flash('success', 'Informações cadastrada com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Session::flash('success', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01ServicesSection  $SERV01ServicesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01ServicesSection $SERV01ServicesSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, 1600, 100);

        if($path_image_banner){
            storageDelete($SERV01ServicesSection, 'path_image_banner');
            $data['path_image_banner'] = $path_image_banner;
        }
        if($request->delete_path_image_banner && !$path_image_banner){
            storageDelete($SERV01ServicesSection, 'path_image_banner');
            $data['path_image_banner'] = null;
        }

        $data['active_section'] = $request->active_section?1:0;

        if($SERV01ServicesSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizada com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }
}
