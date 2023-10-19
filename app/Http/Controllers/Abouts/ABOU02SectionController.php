<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU02AboutsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU02SectionController extends Controller
{
    protected $path = 'uploads/Abouts/ABOU02/images/';

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

        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        //Content
        $path_image_desktop_content = $helper->optimizeImage($request, 'path_image_desktop_content', $this->path, null,100);
        if($path_image_desktop_content) $data['path_image_desktop_content'] = $path_image_desktop_content;

        $path_image_mobile_content = $helper->optimizeImage($request, 'path_image_mobile_content', $this->path, null,100);
        if($path_image_mobile_content) $data['path_image_mobile_content'] = $path_image_mobile_content;

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content) $data['path_image_content'] = $path_image_content;

        if(ABOU02AboutsSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_content);
            Storage::delete($path_image_mobile_content);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU02AboutsSection  $ABOU02AboutsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU02AboutsSection $ABOU02AboutsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($ABOU02AboutsSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($ABOU02AboutsSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($ABOU02AboutsSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($ABOU02AboutsSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        //Content
        $path_image_desktop_content = $helper->optimizeImage($request, 'path_image_desktop_content', $this->path, null,100);
        if($path_image_desktop_content){
            storageDelete($ABOU02AboutsSection, 'path_image_desktop_content');
            $data['path_image_desktop_content'] = $path_image_desktop_content;
        }
        if($request->delete_path_image_desktop_content && !$path_image_desktop_content){
            storageDelete($ABOU02AboutsSection, 'path_image_desktop_content');
            $data['path_image_desktop_content'] = null;
        }

        $path_image_mobile_content = $helper->optimizeImage($request, 'path_image_mobile_content', $this->path, null,100);
        if($path_image_mobile_content){
            storageDelete($ABOU02AboutsSection, 'path_image_mobile_content');
            $data['path_image_mobile_content'] = $path_image_mobile_content;
        }
        if($request->delete_path_image_mobile_content && !$path_image_mobile_content){
            storageDelete($ABOU02AboutsSection, 'path_image_mobile_content');
            $data['path_image_mobile_content'] = null;
        }

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content){
            storageDelete($ABOU02AboutsSection, 'path_image_content');
            $data['path_image_content'] = $path_image_content;
        }
        if($request->delete_path_image_content && !$path_image_content){
            storageDelete($ABOU02AboutsSection, 'path_image_content');
            $data['path_image_content'] = null;
        }

        if($ABOU02AboutsSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_content);
            Storage::delete($path_image_mobile_content);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
