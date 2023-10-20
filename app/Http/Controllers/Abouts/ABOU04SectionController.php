<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU04AboutsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU04SectionController extends Controller
{
    protected $path = 'uploads/Abouts/ABOU04/images/';

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

        $data['link_button_galleries'] = isset($data['link_button_galleries']) ? getUri($data['link_button_galleries']) : null;

        //Section
        $path_image_section = $helper->optimizeImage($request, 'path_image_section', $this->path, null,100);
        if($path_image_section) $data['path_image_section'] = $path_image_section;

        $path_image_desktop_section = $helper->optimizeImage($request, 'path_image_desktop_section', $this->path, null,100);
        if($path_image_desktop_section) $data['path_image_desktop_section'] = $path_image_desktop_section;

        $path_image_mobile_section = $helper->optimizeImage($request, 'path_image_mobile_section', $this->path, null,100);
        if($path_image_mobile_section) $data['path_image_mobile_section'] = $path_image_mobile_section;

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        // Section topics
        $path_image_desktop_topics = $helper->optimizeImage($request, 'path_image_desktop_topics', $this->path, null,100);
        if($path_image_desktop_topics) $data['path_image_desktop_topics'] = $path_image_desktop_topics;

        $path_image_mobile_topics = $helper->optimizeImage($request, 'path_image_mobile_topics', $this->path, null,100);
        if($path_image_mobile_topics) $data['path_image_mobile_topics'] = $path_image_mobile_topics;



        if(ABOU04AboutsSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image_section);
            Storage::delete($path_image_desktop_section);
            Storage::delete($path_image_mobile_section);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_topics);
            Storage::delete($path_image_mobile_topics);
            Session::flash('error', 'Erro ao cadastradar o item');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU04AboutsSection  $ABOU04AboutsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU04AboutsSection $ABOU04AboutsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['link_button_galleries'] = isset($data['link_button_galleries']) ? getUri($data['link_button_galleries']) : null;

        //Section
        $path_image_section = $helper->optimizeImage($request, 'path_image_section', $this->path, null,100);
        if($path_image_section){
            storageDelete($ABOU04AboutsSection, 'path_image_section');
            $data['path_image_section'] = $path_image_section;
        }
        if($request->delete_path_image_section && !$path_image_section){
            storageDelete($ABOU04AboutsSection, 'path_image_section');
            $data['path_image_section'] = null;
        }

        $path_image_desktop_section = $helper->optimizeImage($request, 'path_image_desktop_section', $this->path, null,100);
        if($path_image_desktop_section){
            storageDelete($ABOU04AboutsSection, 'path_image_desktop_section');
            $data['path_image_desktop_section'] = $path_image_desktop_section;
        }
        if($request->delete_path_image_desktop_section && !$path_image_desktop_section){
            storageDelete($ABOU04AboutsSection, 'path_image_desktop_section');
            $data['path_image_desktop_section'] = null;
        }

        $path_image_mobile_section = $helper->optimizeImage($request, 'path_image_mobile_section', $this->path, null,100);
        if($path_image_mobile_section){
            storageDelete($ABOU04AboutsSection, 'path_image_mobile_section');
            $data['path_image_mobile_section'] = $path_image_mobile_section;
        }
        if($request->delete_path_image_mobile_section && !$path_image_mobile_section){
            storageDelete($ABOU04AboutsSection, 'path_image_mobile_section');
            $data['path_image_mobile_section'] = null;
        }
        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($ABOU04AboutsSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($ABOU04AboutsSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($ABOU04AboutsSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($ABOU04AboutsSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        //Section Topics
        $path_image_desktop_topics = $helper->optimizeImage($request, 'path_image_desktop_topics', $this->path, null,100);
        if($path_image_desktop_topics){
            storageDelete($ABOU04AboutsSection, 'path_image_desktop_topics');
            $data['path_image_desktop_topics'] = $path_image_desktop_topics;
        }
        if($request->delete_path_image_desktop_topics && !$path_image_desktop_topics){
            storageDelete($ABOU04AboutsSection, 'path_image_desktop_topics');
            $data['path_image_desktop_topics'] = null;
        }

        $path_image_mobile_topics = $helper->optimizeImage($request, 'path_image_mobile_topics', $this->path, null,100);
        if($path_image_mobile_topics){
            storageDelete($ABOU04AboutsSection, 'path_image_mobile_topics');
            $data['path_image_mobile_topics'] = $path_image_mobile_topics;
        }
        if($request->delete_path_image_mobile_topics && !$path_image_mobile_topics){
            storageDelete($ABOU04AboutsSection, 'path_image_mobile_topics');
            $data['path_image_mobile_topics'] = null;
        }

        if($ABOU04AboutsSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image_section);
            Storage::delete($path_image_desktop_section);
            Storage::delete($path_image_mobile_section);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_topics);
            Storage::delete($path_image_mobile_topics);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
