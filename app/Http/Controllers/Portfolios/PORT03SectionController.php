<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT03PortfoliosSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PORT03SectionController extends Controller
{
    protected $path = 'uploads/Portfolios/PORT03/images/';

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

        $path_image_icon_content = $helper->optimizeImage($request, 'path_image_icon_content', $this->path, null,100);
        if($path_image_icon_content) $data['path_image_icon_content'] = $path_image_icon_content;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        if(PORT03PortfoliosSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image_icon_content);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_banner);
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT03PortfoliosSection  $PORT03PortfoliosSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT03PortfoliosSection $PORT03PortfoliosSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();



        $data['active_section'] = $request->active_section?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_content'] = $request->active_content?1:0;

        // dd($data);

        $path_image_icon_content = $helper->optimizeImage($request, 'path_image_icon_content', $this->path, null,100);
        if($path_image_icon_content){
            storageDelete($PORT03PortfoliosSection, 'path_image_icon_content');
            $data['path_image_icon_content'] = $path_image_icon_content;
        }
        if($request->delete_path_image_icon_content && !$path_image_icon_content){
            storageDelete($PORT03PortfoliosSection, 'path_image_icon_content');
            $data['path_image_icon_content'] = null;
        }

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($PORT03PortfoliosSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($PORT03PortfoliosSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($PORT03PortfoliosSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($PORT03PortfoliosSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }


        if($PORT03PortfoliosSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image_icon_content);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_banner);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }
}
