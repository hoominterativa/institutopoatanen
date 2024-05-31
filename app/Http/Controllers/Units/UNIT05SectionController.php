<?php

namespace App\Http\Controllers\Units;

use App\Models\Units\UNIT05UnitsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT05SectionController extends Controller
{
    protected $path = 'uploads/Units/UNIT05/images/';

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

        $data['active_section'] = $request->active_section ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;

        $path_image_desktop_section = $helper->optimizeImage($request, 'path_image_desktop_section', $this->path, null,100);
        if($path_image_desktop_section) $data['path_image_desktop_section'] = $path_image_desktop_section;

        $path_image_mobile_section = $helper->optimizeImage($request, 'path_image_mobile_section', $this->path, null,100);
        if($path_image_mobile_section) $data['path_image_mobile_section'] = $path_image_mobile_section;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        if(UNIT05UnitsSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image_desktop_section);
            Storage::delete($path_image_mobile_section);
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
     * @param  \App\Models\Units\UNIT05UnitsSection  $UNIT05UnitsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT05UnitsSection $UNIT05UnitsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active_section'] = $request->active_section ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;

        $path_image_desktop_section = $helper->optimizeImage($request, 'path_image_desktop_section', $this->path, null,100);
        if($path_image_desktop_section){
            storageDelete($UNIT05UnitsSection, 'path_image_desktop_section');
            $data['path_image_desktop_section'] = $path_image_desktop_section;
        }
        if($request->delete_path_image_desktop_section && !$path_image_desktop_section){
            storageDelete($UNIT05UnitsSection, 'path_image_desktop_section');
            $data['path_image_desktop_section'] = null;
        }

        $path_image_mobile_section = $helper->optimizeImage($request, 'path_image_mobile_section', $this->path, null,100);
        if($path_image_mobile_section){
            storageDelete($UNIT05UnitsSection, 'path_image_mobile_section');
            $data['path_image_mobile_section'] = $path_image_mobile_section;
        }
        if($request->delete_path_image_mobile_section && !$path_image_mobile_section){
            storageDelete($UNIT05UnitsSection, 'path_image_mobile_section');
            $data['path_image_mobile_section'] = null;
        }

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($UNIT05UnitsSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($UNIT05UnitsSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($UNIT05UnitsSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($UNIT05UnitsSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        if($UNIT05UnitsSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image_desktop_section);
            Storage::delete($path_image_mobile_section);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
