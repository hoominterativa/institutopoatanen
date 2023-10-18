<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU01Abouts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Abouts\ABOU01AboutsSection;
use App\Models\Abouts\ABOU01AboutsTopics;

class ABOU01Controller extends Controller
{
    protected $path = 'uploads/Abouts/ABOU01/images/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = ABOU01Abouts::first();
        $section = ABOU01AboutsSection::first();
        $topics = ABOU01AboutsTopics::sorting()->get();
        return view('Admin.cruds.Abouts.ABOU01.edit',[
            'about' => $about,
            'topics' => $topics,
            'section' => $section,
            'cropSetting' => getCropImage('Abouts', 'ABOU01')
        ]);
    }

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

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image) $data['path_image'] = $path_image;

        if(ABOU01Abouts::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao cadastradar as informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU01Abouts  $ABOU01Abouts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU01Abouts $ABOU01Abouts)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        // path_image_desktop
        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop){
            storageDelete($ABOU01Abouts, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($ABOU01Abouts, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        // path_image_mobile
        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile){
            storageDelete($ABOU01Abouts, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($ABOU01Abouts, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        // path_image
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image){
            storageDelete($ABOU01Abouts, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($ABOU01Abouts, 'path_image');
            $data['path_image'] = null;
        }

        if($ABOU01Abouts->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }

    // METHODS CLIENT

     /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU01');

        $about = ABOU01Abouts::first();
        $section = ABOU01AboutsSection::first();
        $topics = ABOU01AboutsTopics::sorting()->get();

        switch (deviceDetect()) {
            case "mobile":
            case "tablet":
                if($section)
                $section->path_image_banner_desktop = $section->path_image_banner_mobile;
                $section->path_image_topic_desktop = $section->path_image_topic_mobile;
                $section->path_image_content_desktop = $section->path_image_content_mobile;
            break;
        }

        return view('Client.pages.Abouts.ABOU01.page',[
            'about' => $about,
            'sections' => $sections,
            'topics' => $topics,
            'section' => $section
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $section = ABOU01AboutsSection::first();
        switch(deviceDetect()){
            case "mobile":
            case "tablet":
                if($section) $section->path_image_section_desktop = $section->path_image_section_mobile;
            break;
        }

        return view('Client.pages.Abouts.ABOU01.section',[
            'section' => $section
        ]);
    }
}
