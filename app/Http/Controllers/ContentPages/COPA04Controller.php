<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\ContentPages\COPA04ContentPages;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesSectionHero;
use App\Models\ContentPages\COPA04ContentPagesSectionHighlighted;
use App\Models\ContentPages\COPA04ContentPagesSectionVideo;
use App\Models\ContentPages\COPA04ContentPagesTopic;

class COPA04Controller extends Controller
{
    protected $path = 'uploads/Module/sectionHeros/images/';

    public function index()
    {   
        $sectionHeros = COPA04ContentPagesSectionHero::paginate(30);
        $sectionVideo = COPA04ContentPagesSectionVideo::first();
        $sectionHighlighteds = COPA04ContentPagesSectionHighlighted::paginate(30);
        $sectionTopic = COPA04ContentPagesTopic::first();

        return view('Admin.cruds.ContentPages.COPA04.SectionHero.index', [
            'sectionHeros' => $sectionHeros,
            'cropSetting' => getCropImage('ContentPages', 'COPA01'),
            'sectionVideo' => $sectionVideo,
            'sectionHighlighteds' => $sectionHighlighteds,
            'sectionTopic' => $sectionTopic
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit(COPA04ContentPages $COPA04ContentPages)
    {

    }


    public function update(Request $request, COPA04ContentPages $COPA04ContentPages)
    {

    }

    public function destroy(COPA04ContentPages $COPA04ContentPages)
    {

    }

    public function destroySelected(Request $request)
    {

    }

    public function sorting(Request $request)
    {

    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPages  $COPA04ContentPages
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPages $COPA04ContentPages)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model', 'show');

        return view('Client.pages.Module.Model.show',[
            'sections' => $sections
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('ContentPages', 'COPA04', 'page');
        $sectionHeros = COPA04ContentPagesSectionHero::where('active', 1)->first();
        $sectionVideo = COPA04ContentPagesSectionVideo::where('active', 1)->first();
        $sectionHighlighteds = COPA04ContentPagesSectionHighlighted::where('active', 1)->first();
        $sectionTopic = COPA04ContentPagesTopic::first();

        return view('Client.pages.ContentPages.COPA04.page',[
            'sections' => $sections,
            'sectionHeros' => $sectionHeros,
            'sectionVideo' => $sectionVideo,
            'sectionHighlighted' => $sectionHighlighteds,
            'sectionTopic' => $sectionTopic,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('');
    }
}
