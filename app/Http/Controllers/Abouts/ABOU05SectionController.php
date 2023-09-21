<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU05AboutsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU05SectionController extends Controller
{
    protected $path = 'uploads/Abouts/ABOU05/images/';

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
        $data['active_content'] = $request->active_content?1:0;

        //Section
        $path_image_desktop_section = $helper->optimizeImage($request, 'path_image_desktop_section', $this->path, null,100);
        if($path_image_desktop_section) $data['path_image_desktop_section'] = $path_image_desktop_section;

        $path_image_mobile_section = $helper->optimizeImage($request, 'path_image_mobile_section', $this->path, null,100);
        if($path_image_mobile_section) $data['path_image_mobile_section'] = $path_image_mobile_section;

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        if(ABOU05AboutsSection::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image_desktop_section);
            Storage::delete($path_image_mobile_section);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao cadastradar as informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU05AboutsSection  $ABOU05AboutsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU05AboutsSection $ABOU05AboutsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active_section'] = $request->active_section?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_content'] = $request->active_content?1:0;

        //Section
        $path_image_desktop_section = $helper->optimizeImage($request, 'path_image_desktop_section', $this->path, null,100);
        if($path_image_desktop_section){
            storageDelete($ABOU05AboutsSection, 'path_image_desktop_section');
            $data['path_image_desktop_section'] = $path_image_desktop_section;
        }
        if($request->delete_path_image_desktop_section && !$path_image_desktop_section){
            storageDelete($ABOU05AboutsSection, 'path_image_desktop_section');
            $data['path_image_desktop_section'] = null;
        }

        $path_image_mobile_section = $helper->optimizeImage($request, 'path_image_mobile_section', $this->path, null,100);
        if($path_image_mobile_section){
            storageDelete($ABOU05AboutsSection, 'path_image_mobile_section');
            $data['path_image_mobile_section'] = $path_image_mobile_section;
        }
        if($request->delete_path_image_mobile_section && !$path_image_mobile_section){
            storageDelete($ABOU05AboutsSection, 'path_image_mobile_section');
            $data['path_image_mobile_section'] = null;
        }

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($ABOU05AboutsSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($ABOU05AboutsSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($ABOU05AboutsSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($ABOU05AboutsSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        if($ABOU05AboutsSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_desktop_section);
            Storage::delete($path_image_mobile_section);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }
}
