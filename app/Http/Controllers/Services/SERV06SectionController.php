<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV06ServicesSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV06SectionController extends Controller
{
    protected $path = 'uploads/Services/SERV06/images/';

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

        $data['active_section'] = $request->active_section?1:0;
        $data['active_banner'] = $request->active_banner?1:0;

        $path_image_section = $helper->optimizeImage($request, 'path_image_section', $this->path, null,100);
        if($path_image_section) $data['path_image_section'] = $path_image_section;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        if(SERV06ServicesSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image_section);
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
     * @param  \App\Models\Services\SERV06ServicesSection  $SERV06ServicesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV06ServicesSection $SERV06ServicesSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active_section'] = $request->active_section?1:0;
        $data['active_banner'] = $request->active_banner?1:0;

        $path_image_section = $helper->optimizeImage($request, 'path_image_section', $this->path, null,100);
        if($path_image_section){
            storageDelete($SERV06ServicesSection, 'path_image_section');
            $data['path_image_section'] = $path_image_section;
        }
        if($request->delete_path_image_section && !$path_image_section){
            storageDelete($SERV06ServicesSection, 'path_image_section');
            $data['path_image_section'] = null;
        }

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($SERV06ServicesSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($SERV06ServicesSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($SERV06ServicesSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($SERV06ServicesSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        if($SERV06ServicesSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image_section);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
