<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV05ServicesSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV05SectionController extends Controller
{
    protected $path = 'uploads/Services/SERV05/images/';

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
        $data['active_about'] = $request->active_about?1:0;
        $data['active_banner'] = $request->active_banner?1:0;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        if(SERV05ServicesSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV05ServicesSection  $SERV05ServicesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV05ServicesSection $SERV05ServicesSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['active_about'] = $request->active_about?1:0;
        $data['active_banner'] = $request->active_banner?1:0;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($SERV05ServicesSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($SERV05ServicesSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($SERV05ServicesSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($SERV05ServicesSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        if($SERV05ServicesSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizado com sucesso');
        }else{
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
