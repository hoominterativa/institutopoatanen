<?php

namespace App\Http\Controllers\Brands;

use App\Models\Brands\BRAN01BrandsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class BRAN01SectionController extends Controller
{
    protected $path = 'uploads/Brands/BRAN01/images/';
    
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

        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['active_section'] = $request->active_section ? 1 : 0;
        $data['active_home'] = $request->active_home ? 1 : 0;

        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop) $data['path_image_banner_desktop'] = $path_image_banner_desktop;

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile) $data['path_image_banner_mobile'] = $path_image_banner_mobile;

        $path_image_section_desktop = $helper->optimizeImage($request, 'path_image_section_desktop', $this->path, null,100);
        if($path_image_section_desktop) $data['path_image_section_desktop'] = $path_image_section_desktop;

        $path_image_section_mobile = $helper->optimizeImage($request, 'path_image_section_mobile', $this->path, null,100);
        if($path_image_section_mobile) $data['path_image_section_mobile'] = $path_image_section_mobile;

        $path_image_home_desktop = $helper->optimizeImage($request, 'path_image_home_desktop', $this->path, null,100);
        if($path_image_home_desktop) $data['path_image_home_desktop'] = $path_image_home_desktop;

        $path_image_home_mobile = $helper->optimizeImage($request, 'path_image_home_mobile', $this->path, null,100);
        if($path_image_home_mobile) $data['path_image_home_mobile'] = $path_image_home_mobile;

        if(BRAN01BrandsSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_section_desktop);
            Storage::delete($path_image_section_mobile);
            Storage::delete($path_image_home_desktop);
            Storage::delete($path_image_home_mobile);
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brands\BRAN01BrandsSection  $BRAN01BrandsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BRAN01BrandsSection $BRAN01BrandsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active_banner'] = $request->active_banner ? 1 : 0;
       
        $data['active_section'] = $request->active_section ? 1 : 0;
        
        $data['active_home'] = $request->active_home ? 1 : 0;

        //Banner
        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop){
            storageDelete($BRAN01BrandsSection, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = $path_image_banner_desktop;
        }
        if($request->delete_path_image_banner_desktop && !$path_image_banner_desktop){
            storageDelete($BRAN01BrandsSection, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = null;
        }

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile){
            storageDelete($BRAN01BrandsSection, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = $path_image_banner_mobile;
        }
        if($request->delete_path_image_banner_mobile && !$path_image_banner_mobile){
            storageDelete($BRAN01BrandsSection, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = null;
        }

        //Section
        $path_image_section_desktop = $helper->optimizeImage($request, 'path_image_section_desktop', $this->path, null,100);
        if($path_image_section_desktop){
            storageDelete($BRAN01BrandsSection, 'path_image_section_desktop');
            $data['path_image_section_desktop'] = $path_image_section_desktop;
        }
        if($request->delete_path_image_section_desktop && !$path_image_section_desktop){
            storageDelete($BRAN01BrandsSection, 'path_image_section_desktop');
            $data['path_image_section_desktop'] = null;
        }

        $path_image_section_mobile = $helper->optimizeImage($request, 'path_image_section_mobile', $this->path, null,100);
        if($path_image_section_mobile){
            storageDelete($BRAN01BrandsSection, 'path_image_section_mobile');
            $data['path_image_section_mobile'] = $path_image_section_mobile;
        }
        if($request->delete_path_image_section_mobile && !$path_image_section_mobile){
            storageDelete($BRAN01BrandsSection, 'path_image_section_mobile');
            $data['path_image_section_mobile'] = null;
        }

        //Home
        $path_image_home_desktop = $helper->optimizeImage($request, 'path_image_home_desktop', $this->path, null,100);
        if($path_image_home_desktop){
            storageDelete($BRAN01BrandsSection, 'path_image_home_desktop');
            $data['path_image_home_desktop'] = $path_image_home_desktop;
        }
        if($request->delete_path_image_home_desktop && !$path_image_home_desktop){
            storageDelete($BRAN01BrandsSection, 'path_image_home_desktop');
            $data['path_image_home_desktop'] = null;
        }

        $path_image_home_mobile = $helper->optimizeImage($request, 'path_image_home_mobile', $this->path, null,100);
        if($path_image_home_mobile){
            storageDelete($BRAN01BrandsSection, 'path_image_home_mobile');
            $data['path_image_home_mobile'] = $path_image_home_mobile;
        }
        if($request->delete_path_image_home_mobile && !$path_image_home_mobile){
            storageDelete($BRAN01BrandsSection, 'path_image_home_mobile');
            $data['path_image_home_mobile'] = null;
        }

        if($BRAN01BrandsSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_section_desktop);
            Storage::delete($path_image_section_mobile);
            Storage::delete($path_image_home_desktop);
            Storage::delete($path_image_home_mobile);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
