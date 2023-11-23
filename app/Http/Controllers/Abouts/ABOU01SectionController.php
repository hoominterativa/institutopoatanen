<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU01AboutsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU01SectionController extends Controller
{
    protected $path = 'uploads/Abouts/ABOU01/images/';
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
        $data['link_button_content'] = isset($data['link_button_content']) ? getUri($data['link_button_content']) : null;

        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null, 100);
        if($path_image_banner_desktop) $data['path_image_banner_desktop'] = $path_image_banner_desktop;

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null, 100);
        if($path_image_banner_mobile) $data['path_image_banner_mobile'] = $path_image_banner_mobile;

        $path_image_content_desktop = $helper->optimizeImage($request, 'path_image_content_desktop', $this->path, null, 100);
        if($path_image_content_desktop) $data['path_image_content_desktop'] = $path_image_content_desktop;

        $path_image_content_mobile = $helper->optimizeImage($request, 'path_image_content_mobile', $this->path, null, 100);
        if($path_image_content_mobile) $data['path_image_content_mobile'] = $path_image_content_mobile;

        $path_image_section_desktop = $helper->optimizeImage($request, 'path_image_section_desktop', $this->path, null, 100);
        if($path_image_section_desktop) $data['path_image_section_desktop'] = $path_image_section_desktop;

        $path_image_section_mobile = $helper->optimizeImage($request, 'path_image_section_mobile', $this->path, null, 100);
        if($path_image_section_mobile) $data['path_image_section_mobile'] = $path_image_section_mobile;

        $path_image_topic_desktop = $helper->optimizeImage($request, 'path_image_topic_desktop', $this->path, null, 100);
        if($path_image_topic_desktop) $data['path_image_topic_desktop'] = $path_image_topic_desktop;

        $path_image_topic_mobile = $helper->optimizeImage($request, 'path_image_topic_mobile', $this->path, null, 100);
        if($path_image_topic_mobile) $data['path_image_topic_mobile'] = $path_image_topic_mobile;

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null, 100);
        if($path_image_content) $data['path_image_content'] = $path_image_content;



        if(ABOU01AboutsSection::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_section_desktop);
            Storage::delete($path_image_section_mobile);
            Storage::delete($path_image_topic_desktop);
            Storage::delete($path_image_topic_mobile);
            Storage::delete($path_image_content_desktop);
            Storage::delete($path_image_content_mobile);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao cadastradar o item');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU01AboutsSection  $ABOU01AboutsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU01AboutsSection $ABOU01AboutsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active_section'] = $request->active_section?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_content'] = $request->active_content?1:0;
        $data['link_button_content'] = isset($data['link_button_content']) ? getUri($data['link_button_content']) : null;

        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null, 100);
        if($path_image_banner_desktop){
            storageDelete($ABOU01AboutsSection, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = $path_image_banner_desktop;
        }
        if($request->delete_path_image_banner_desktop && !$path_image_banner_desktop){
            storageDelete($ABOU01AboutsSection, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = null;
        }

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null, 100);
        if($path_image_banner_mobile){
            storageDelete($ABOU01AboutsSection, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = $path_image_banner_mobile;
        }
        if($request->delete_path_image_banner_mobile && !$path_image_banner_mobile){
            storageDelete($ABOU01AboutsSection, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = null;
        }

        $path_image_content_desktop = $helper->optimizeImage($request, 'path_image_content_desktop', $this->path, null, 100);
        if($path_image_content_desktop){
            storageDelete($ABOU01AboutsSection, 'path_image_content_desktop');
            $data['path_image_content_desktop'] = $path_image_content_desktop;
        }
        if($request->delete_path_image_content_desktop && !$path_image_content_desktop){
            storageDelete($ABOU01AboutsSection, 'path_image_content_desktop');
            $data['path_image_content_desktop'] = null;
        }

        $path_image_content_mobile = $helper->optimizeImage($request, 'path_image_content_mobile', $this->path, null, 100);
        if($path_image_content_mobile){
            storageDelete($ABOU01AboutsSection, 'path_image_content_mobile');
            $data['path_image_content_mobile'] = $path_image_content_mobile;
        }
        if($request->delete_path_image_content_mobile && !$path_image_content_mobile){
            storageDelete($ABOU01AboutsSection, 'path_image_content_mobile');
            $data['path_image_content_mobile'] = null;
        }

        $path_image_section_desktop = $helper->optimizeImage($request, 'path_image_section_desktop', $this->path, null, 100);
        if($path_image_section_desktop){
            storageDelete($ABOU01AboutsSection, 'path_image_section_desktop');
            $data['path_image_section_desktop'] = $path_image_section_desktop;
        }
        if($request->delete_path_image_section_desktop && !$path_image_section_desktop){
            storageDelete($ABOU01AboutsSection, 'path_image_section_desktop');
            $data['path_image_section_desktop'] = null;
        }

        $path_image_section_mobile = $helper->optimizeImage($request, 'path_image_section_mobile', $this->path, null, 100);
        if($path_image_section_mobile){
            storageDelete($ABOU01AboutsSection, 'path_image_section_mobile');
            $data['path_image_section_mobile'] = $path_image_section_mobile;
        }
        if($request->delete_path_image_section_mobile && !$path_image_section_mobile){
            storageDelete($ABOU01AboutsSection, 'path_image_section_mobile');
            $data['path_image_section_mobile'] = null;
        }

        $path_image_topic_desktop = $helper->optimizeImage($request, 'path_image_topic_desktop', $this->path, null, 100);
        if($path_image_topic_desktop){
            storageDelete($ABOU01AboutsSection, 'path_image_topic_desktop');
            $data['path_image_topic_desktop'] = $path_image_topic_desktop;
        }
        if($request->delete_path_image_topic_desktop && !$path_image_topic_desktop){
            storageDelete($ABOU01AboutsSection, 'path_image_topic_desktop');
            $data['path_image_topic_desktop'] = null;
        }

        $path_image_topic_mobile = $helper->optimizeImage($request, 'path_image_topic_mobile', $this->path, null, 100);
        if($path_image_topic_mobile){
            storageDelete($ABOU01AboutsSection, 'path_image_topic_mobile');
            $data['path_image_topic_mobile'] = $path_image_topic_mobile;
        }
        if($request->delete_path_image_topic_mobile && !$path_image_topic_mobile){
            storageDelete($ABOU01AboutsSection, 'path_image_topic_mobile');
            $data['path_image_topic_mobile'] = null;
        }

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null, 100);
        if($path_image_content){
            storageDelete($ABOU01AboutsSection, 'path_image_content');
            $data['path_image_content'] = $path_image_content;
        }
        if($request->delete_path_image_content && !$path_image_content){
            storageDelete($ABOU01AboutsSection, 'path_image_content');
            $data['path_image_content'] = null;
        }

        if($ABOU01AboutsSection->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_section_desktop);
            Storage::delete($path_image_section_mobile);
            Storage::delete($path_image_topic_desktop);
            Storage::delete($path_image_topic_mobile);
            Storage::delete($path_image_content_desktop);
            Storage::delete($path_image_content_mobile);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }
}
