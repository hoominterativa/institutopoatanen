<?php

namespace App\Http\Controllers\Abouts;

use Illuminate\Http\Request;
use App\Models\Abouts\ABOU02Abouts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Abouts\ABOU02AboutsBanner;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Abouts\ABOU02AboutsSectionTopic;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Abouts\ABOU02AboutsLastSection;
use App\Models\Abouts\ABOU02AboutsSection;
use App\Models\Abouts\ABOU02AboutsTopic;

class ABOU02Controller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = ABOU02Abouts::first();
        $topics = ABOU02AboutsTopic::sorting()->get();
        $section = ABOU02AboutsSection::first();
        return view('Admin.cruds.Abouts.ABOU02.edit', [
            'about' => $about,
            'section' => $section,
            'topics' => $topics,
            'cropSetting' => getCropImage('Abouts', 'ABOU02')
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

        if(ABOU02Abouts::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Session::flash('success', 'Erro ao cadastradar as informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU02Abouts  $ABOU02Abouts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU02Abouts $ABOU02Abouts)
    {
        $data = $request->all();

        if($ABOU02Abouts->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
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
        $section = ABOU02AboutsSection::first();
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($section)
                $section->path_image_banner_desktop = $section->path_image_banner_mobile;
                $section->path_image_desktop_content = $section->path_image_mobile_content;
            break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU02');

        $about = ABOU02Abouts::first();
        $topics = ABOU02AboutsTopic::active()->sorting()->get();

        return view('Client.pages.Abouts.ABOU02.page',[
            'sections' => $sections,
            'about' => $about,
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
        $topics = ABOU02AboutsTopic::active()->featured()->sorting()->get();
        $section = ABOU02AboutsSection::activeSection()->first();

        return view('Client.pages.Abouts.ABOU02.section', [
            'section' => $section,
            'topics' => $topics
        ]);
    }
}
