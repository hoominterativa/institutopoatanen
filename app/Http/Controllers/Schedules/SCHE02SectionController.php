<?php

namespace App\Http\Controllers\Schedules;

use App\Models\Schedules\SCHE02SchedulesSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SCHE02SectionController extends Controller
{
    protected $path = 'uploads/Schedules/SCHE02/images/';

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

        //Section
        $path_image_section = $helper->optimizeImage($request, 'path_image_section', $this->path, null,100);
        if($path_image_section) $data['path_image_section'] = $path_image_section;

        $path_image_mobile_section = $helper->optimizeImage($request, 'path_image_mobile_section', $this->path, null,100);
        if($path_image_mobile_section) $data['path_image_mobile_section'] = $path_image_mobile_section;

        $path_image_desktop_section = $helper->optimizeImage($request, 'path_image_desktop_section', $this->path, null,100);
        if($path_image_desktop_section) $data['path_image_desktop_section'] = $path_image_desktop_section;

        //Banner
        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null,100);
        if($path_image_banner) $data['path_image_banner'] = $path_image_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        if(SCHE02SchedulesSection::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image_section);
            Storage::delete($$path_image_mobile_section);
            Storage::delete($path_image_desktop_section);
            Storage::delete($path_image_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_banner);
            Session::flash('error', 'Erro ao cadastradar as informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedules\SCHE02SchedulesSection  $SCHE02SchedulesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SCHE02SchedulesSection $SCHE02SchedulesSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        //Section
        $path_image_section = $helper->optimizeImage($request, 'path_image_section', $this->path, null,100);
        if($path_image_section){
            storageDelete($SCHE02SchedulesSection, 'path_image_section');
            $data['path_image_section'] = $path_image_section;
        }
        if($request->delete_path_image_section && !$path_image_section){
            storageDelete($SCHE02SchedulesSection, 'path_image_section');
            $data['path_image_section'] = null;
        }

        $path_image_mobile_section = $helper->optimizeImage($request, 'path_image_mobile_section', $this->path, null,100);
        if($path_image_mobile_section){
            storageDelete($SCHE02SchedulesSection, 'path_image_mobile_section');
            $data['path_image_mobile_section'] = $path_image_mobile_section;
        }
        if($request->delete_path_image_mobile_section && !$path_image_mobile_section){
            storageDelete($SCHE02SchedulesSection, 'path_image_mobile_section');
            $data['path_image_mobile_section'] = null;
        }

        $path_image_desktop_section = $helper->optimizeImage($request, 'path_image_desktop_section', $this->path, null,100);
        if($path_image_desktop_section){
            storageDelete($SCHE02SchedulesSection, 'path_image_desktop_section');
            $data['path_image_desktop_section'] = $path_image_desktop_section;
        }
        if($request->delete_path_image_desktop_section && !$path_image_desktop_section){
            storageDelete($SCHE02SchedulesSection, 'path_image_desktop_section');
            $data['path_image_desktop_section'] = null;
        }

        //Banner
        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null,100);
        if($path_image_banner){
            storageDelete($SCHE02SchedulesSection, 'path_image_banner');
            $data['path_image_banner'] = $path_image_banner;
        }
        if($request->delete_path_image_banner && !$path_image_banner){
            storageDelete($SCHE02SchedulesSection, 'path_image_banner');
            $data['path_image_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($SCHE02SchedulesSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($SCHE02SchedulesSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($SCHE02SchedulesSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($SCHE02SchedulesSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        if($SCHE02SchedulesSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_section);
            Storage::delete($$path_image_mobile_section);
            Storage::delete($path_image_desktop_section);
            Storage::delete($path_image_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_banner);
            Session::flash('error', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }
}
