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

class ABOU02Controller extends Controller
{
    protected $path = 'uploads/Abouts/ABOU02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = ABOU02Abouts::with('topics')->first();
        $banner = ABOU02AboutsBanner::first();
        $sectionTopic = ABOU02AboutsSectionTopic::first();
        $lastSection = ABOU02AboutsLastSection::first();
        $section = ABOU02AboutsSection::first();
        return view('Admin.cruds.Abouts.ABOU02.edit', [
            'about' => $about,
            'banner' => $banner,
            'sectionTopic' => $sectionTopic,
            'lastSection' => $lastSection,
            'section' => $section,
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
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Abouts\ABOU02Abouts  $ABOU02Abouts
     * @return \Illuminate\Http\Response
     */
    //public function show(ABOU02Abouts $ABOU02Abouts)
    public function show()
    {
        //
        return view('Client.pages.Abouts.ABOU02.show');
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $banner = ABOU02AboutsBanner::active()->first();
                if($banner) $banner->path_image_desktop = $banner->path_image_mobile;
                break;
            default:
                $banner = ABOU02AboutsBanner::active()->first();
                break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU02');

        $about = ABOU02Abouts::with(['topics' => function ($query) {$query->where('active', 1);}])->first();

        $sectionTopic = ABOU02AboutsSectionTopic::active()->first();
        $lastSection = ABOU02AboutsLastSection::active()->first();

        return view('Client.pages.Abouts.ABOU02.page',[
            'sections' => $sections,
            'banner' => $banner,
            'about' => $about,
            'sectionTopic' => $sectionTopic,
            'lastSection' => $lastSection,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $about = ABOU02Abouts::with(['topics' => function ($query) {$query->where(['featured' => 1, 'active' => 1]);}])->first();
        $section = ABOU02AboutsSection::active()->first();

        return view('Client.pages.Abouts.ABOU02.section', [
            'section' => $section,
            'about' => $about,
        ]);
    }
}
