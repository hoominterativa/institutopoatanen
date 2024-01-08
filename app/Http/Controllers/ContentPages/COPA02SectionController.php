<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA02ContentPagesSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA02SectionController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA02/images/';

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

        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_content'] = $request->active_content?1:0;
        $data['active_section_topic'] = $request->active_section_topic?1:0;
        $data['active_last_section'] = $request->active_last_section?1:0;

        $data['link_button_last_section'] = isset($data['link_button_last_section']) ? getUri($data['link_button_last_section']) : null;

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

        //Last Section
        $path_image_desktop_last_section = $helper->optimizeImage($request, 'path_image_desktop_last_section', $this->path, null,100);
        if($path_image_desktop_last_section) $data['path_image_desktop_last_section'] = $path_image_desktop_last_section;

        $path_image_mobile_last_section = $helper->optimizeImage($request, 'path_image_mobile_last_section', $this->path, null,100);
        if($path_image_mobile_last_section) $data['path_image_mobile_last_section'] = $path_image_mobile_last_section;

        $path_image_box_last_section = $helper->optimizeImage($request, 'path_image_box_last_section', $this->path, null,100);
        if($path_image_box_last_section) $data['path_image_box_last_section'] = $path_image_box_last_section;

        if(COPA02ContentPagesSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_content);
            Storage::delete($path_image_mobile_content);
            Storage::delete($path_image_desktop_last_section);
            Storage::delete($path_image_mobile_last_section);
            Storage::delete($path_image_box_last_section);
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA02ContentPagesSection  $COPA02ContentPagesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA02ContentPagesSection $COPA02ContentPagesSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_content'] = $request->active_content?1:0;
        $data['active_section_topic'] = $request->active_section_topic?1:0;
        $data['active_last_section'] = $request->active_last_section?1:0;

        $data['link_button_last_section'] = isset($data['link_button_last_section']) ? getUri($data['link_button_last_section']) : null;

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($COPA02ContentPagesSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($COPA02ContentPagesSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($COPA02ContentPagesSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($COPA02ContentPagesSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        //Content
        $path_image_desktop_content = $helper->optimizeImage($request, 'path_image_desktop_content', $this->path, null,100);
        if($path_image_desktop_content){
            storageDelete($COPA02ContentPagesSection, 'path_image_desktop_content');
            $data['path_image_desktop_content'] = $path_image_desktop_content;
        }
        if($request->delete_path_image_desktop_content && !$path_image_desktop_content){
            storageDelete($COPA02ContentPagesSection, 'path_image_desktop_content');
            $data['path_image_desktop_content'] = null;
        }

        $path_image_mobile_content = $helper->optimizeImage($request, 'path_image_mobile_content', $this->path, null,100);
        if($path_image_mobile_content){
            storageDelete($COPA02ContentPagesSection, 'path_image_mobile_content');
            $data['path_image_mobile_content'] = $path_image_mobile_content;
        }
        if($request->delete_path_image_mobile_content && !$path_image_mobile_content){
            storageDelete($COPA02ContentPagesSection, 'path_image_mobile_content');
            $data['path_image_mobile_content'] = null;
        }

        //Last Section
        $path_image_desktop_last_section = $helper->optimizeImage($request, 'path_image_desktop_last_section', $this->path, null,100);
        if($path_image_desktop_last_section){
            storageDelete($COPA02ContentPagesSection, 'path_image_desktop_last_section');
            $data['path_image_desktop_last_section'] = $path_image_desktop_last_section;
        }
        if($request->delete_path_image_desktop_last_section && !$path_image_desktop_last_section){
            storageDelete($COPA02ContentPagesSection, 'path_image_desktop_last_section');
            $data['path_image_desktop_last_section'] = null;
        }

        $path_image_mobile_last_section = $helper->optimizeImage($request, 'path_image_mobile_last_section', $this->path, null,100);
        if($path_image_mobile_last_section){
            storageDelete($COPA02ContentPagesSection, 'path_image_mobile_last_section');
            $data['path_image_mobile_last_section'] = $path_image_mobile_last_section;
        }
        if($request->delete_path_image_mobile_last_section && !$path_image_mobile_last_section){
            storageDelete($COPA02ContentPagesSection, 'path_image_mobile_last_section');
            $data['path_image_mobile_last_section'] = null;
        }

        $path_image_box_last_section = $helper->optimizeImage($request, 'path_image_box_last_section', $this->path, null,100);
        if($path_image_box_last_section){
            storageDelete($COPA02ContentPagesSection, 'path_image_box_last_section');
            $data['path_image_box_last_section'] = $path_image_box_last_section;
        }
        if($request->delete_path_image_box_last_section && !$path_image_box_last_section){
            storageDelete($COPA02ContentPagesSection, 'path_image_box_last_section');
            $data['path_image_box_last_section'] = null;
        }

        if($COPA02ContentPagesSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_content);
            Storage::delete($path_image_mobile_content);
            Storage::delete($path_image_desktop_last_section);
            Storage::delete($path_image_mobile_last_section);
            Storage::delete($path_image_box_last_section);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
