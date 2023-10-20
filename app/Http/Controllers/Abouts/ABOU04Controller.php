<?php

namespace App\Http\Controllers\Abouts;

use Illuminate\Http\Request;
use App\Models\Abouts\ABOU04Abouts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Abouts\ABOU04AboutsTopic;
use Illuminate\Support\Facades\Response;
use App\Models\Abouts\ABOU04AboutsBanner;
use App\Models\Abouts\ABOU04AboutsGallery;
use App\Models\Abouts\ABOU04AboutsSection;
use App\Models\Abouts\ABOU04AboutsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Abouts\ABOU04AboutsSectionTopic;
use App\Models\Abouts\ABOU04AboutsSectionGallery;
use App\Http\Controllers\IncludeSectionsController;

class ABOU04Controller extends Controller
{
    protected $path = 'uploads/Abouts/ABOU04/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = ABOU04Abouts::first();
        $section = ABOU04AboutsSection::first();
        $galleries = ABOU04AboutsGallery::with('category')->sorting()->get();
        $categories = ABOU04AboutsCategory::exists()->sorting()->pluck('title', 'id');
        $categoryCreate = ABOU04AboutsCategory::sorting()->pluck('title', 'id');
        $galleryCategories = ABOU04AboutsCategory::sorting()->get();
        $topics = ABOU04AboutsTopic::sorting()->get();
        return view('Admin.cruds.Abouts.ABOU04.edit', [
            'about' => $about,
            'section' => $section,
            'galleries' => $galleries,
            'categories' => $categories,
            'galleryCategories' => $galleryCategories,
            'categoryCreate' => $categoryCreate,
            'topics' => $topics,
            'cropSetting' => getCropImage('Abouts', 'ABOU04')
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(ABOU04Abouts::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar as informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU04Abouts  $ABOU04Abouts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU04Abouts $ABOU04Abouts)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($ABOU04Abouts, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($ABOU04Abouts, 'path_image');
            $data['path_image'] = null;
        }

        if($ABOU04Abouts->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Abouts\ABOU04Abouts  $ABOU04Abouts
     * @return \Illuminate\Http\Response
     */
    //public function show(ABOU04Abouts $ABOU04Abouts)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU04', 'show');

        return view('Client.pages.Abouts.ABOU04.show',[
            'sections' => $sections
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, ABOU04AboutsCategory $ABOU04AboutsCategory)
    {
        $section = ABOU04AboutsSection::first();
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($section)
                $section->path_image_desktop_banner = $section->path_image_mobile_banner;
                $section->path_image_desktop_topics = $section->path_image_mobile_topics;
            break;

        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU04', 'page');

        $about = ABOU04Abouts::first();
        $categories = ABOU04AboutsCategory::with(['galleries' => function ($query) {$query->where('active', 1);}])->exists()->active()->sorting()->get();
        $topics = ABOU04AboutsTopic::active()->sorting()->get();

        return view('Client.pages.Abouts.ABOU04.page',[
            'sections' => $sections,
            'about' => $about,
            'categories' => $categories,
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
        $section = ABOU04AboutsSection::first();
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($section)
                $section->path_image_desktop_section = $section->path_image_mobile_section;
            break;
        }
        return view('Client.pages.Abouts.ABOU04.section', [
            'section' => $section
        ]);
    }
}
